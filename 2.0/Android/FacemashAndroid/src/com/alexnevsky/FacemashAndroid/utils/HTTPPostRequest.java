package com.alexnevsky.FacemashAndroid.utils;

import android.os.AsyncTask;
import android.util.Log;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.List;
import java.util.Map;

/**
 * User: Alex Nevsky
 * Date: 25.10.13
 */
public class HTTPPostRequest extends AsyncTask<Collection, Void, Integer> {

	private static final String TAG = HTTPPostRequest.class.getName();

	private String url;
	private Map<String, String> paramsMap;
	private HttpResponse response;
	private InternetRequirable internetRequirable;

	public HTTPPostRequest(String url, Map<String, String> paramsMap) {
		this.url = url;
		this.paramsMap = paramsMap;
	}

	public HTTPPostRequest(String url, Map<String, String> paramsMap, InternetRequirable internetRequirable) {
		this.url = url;
		this.paramsMap = paramsMap;
		this.internetRequirable = internetRequirable;
	}

	/**
	 * Do HTTP POST Request programmatically on Android.
	 *
	 * @param url
	 *            Form URL.
	 * @param paramsMap
	 *            Request query parameters.
	 *
	 * @see //http://stackoverflow.com/questions/2938502/
	 *      sending-post-data-in-android
	 */
	private void postData(String url, Map<String, String> paramsMap) {
		// Create a new HttpClient and Post Header
		HttpClient httpclient = new DefaultHttpClient();
		HttpPost httppost = new HttpPost(url);

		try {
			// Add your data
			List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(paramsMap.size());
			for (Map.Entry<String, String> entry : paramsMap.entrySet()) {
				String key = entry.getKey();
				String value = entry.getValue();
				nameValuePairs.add(new BasicNameValuePair(key, value));
			}
			httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs, "UTF-8"));

			// Execute HTTP Post Request
			response = httpclient.execute(httppost);
		} catch (ClientProtocolException e) {
			Log.v(TAG, e.toString());
		} catch (IOException e) {
			Log.v(TAG, e.toString());
		}
	}

	@Override
	protected Integer doInBackground(Collection... collections) {
		postData(url, paramsMap);
		if (response != null) {
		    return response.getStatusLine().getStatusCode();
		} else {
			return null;
		}
	}

	@Override
	protected void onPostExecute(Integer integer) {
		super.onPostExecute(integer);
		if (response == null && internetRequirable != null) {
			internetRequirable.setIsInternet(false);
		} else if (internetRequirable != null) {
			internetRequirable.setIsInternet(true);
		}
	}
}
