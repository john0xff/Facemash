package com.alexnevsky.FacemashAndroid.activities;

import android.app.Activity;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.view.KeyEvent;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;
import com.alexnevsky.FacemashAndroid.R;

/**
 * User: Alex Nevsky
 * Date: 22.10.13
 */
public class Top100Activity extends Activity {

	private static final String TAG = Top100Activity.class.getName();

	private WebView myWebView;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		// Must be first!
		// Let's display the progress in the activity title bar, like the browser app does.
		getWindow().requestFeature(Window.FEATURE_PROGRESS);

		setContentView(R.layout.top100);

		// Show the Up button in the action bar.
		getActionBar().setDisplayHomeAsUpEnabled(true);

		// Hide top system bar.
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);

		myWebView = (WebView) findViewById(R.id.top100WebView);

		loadTop100();

		Log.v(TAG, "Top100Activity created!");
	}

	private void loadTop100() {
		// Enabling JavaScript
		WebSettings webSettings = myWebView.getSettings();
		webSettings.setJavaScriptEnabled(true);

		// Progress notification
		final Activity activity = this;
		myWebView.setWebChromeClient(new WebChromeClient() {
			public void onProgressChanged(WebView view, int progress) {
				// Activities and WebViews measure progress with different scales.
				// The progress meter will automatically disappear when we reach 100%
				activity.setProgress(progress * 1000);
			}
		});

		// Handling Page Navigation and Errors
		myWebView.setWebViewClient(new MyWebViewClient() {
			public void onReceivedError(WebView view, int errorCode, String description, String failingUrl) {
				Toast.makeText(activity, "Oh no! " + description, Toast.LENGTH_SHORT).show();
			}
		});

		myWebView.loadUrl("http://www.atenwood.com/facemash/top");
	}

	private class MyWebViewClient extends WebViewClient {
		@Override
		public boolean shouldOverrideUrlLoading(WebView view, String url) {
			if (Uri.parse(url).getHost().equals("www.atenwood.com")) {
				// This is my web site, so do not override; let my WebView load the page
				return false;
			}
			// Otherwise, the link is not for a page on my site, so launch another Activity that handles URLs
			Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
			startActivity(intent);
			return true;
		}
	}

	// Navigating web page history
	@Override
	public boolean onKeyDown(int keyCode, KeyEvent event) {
		// Check if the key event was the Back button and if there's history
		if ((keyCode == KeyEvent.KEYCODE_BACK) && myWebView.canGoBack()) {
			myWebView.goBack();
			return true;
		}
		// If it wasn't the Back key or there's no web page history, bubble up to the default
		// system behavior (probably exit the activity)
		return super.onKeyDown(keyCode, event);
	}
}
