package com.alexnevsky.FacemashAndroid.activities;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.*;
import android.view.animation.AnimationUtils;
import android.widget.ImageView;
import android.widget.TextView;
import com.alexnevsky.FacemashAndroid.R;
import com.alexnevsky.FacemashAndroid.model.Face;
import com.alexnevsky.FacemashAndroid.storage.Base;
import com.alexnevsky.FacemashAndroid.utils.*;

import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;

public class MainActivity extends Activity implements InternetRequirable {

	private static final String TAG = MainActivity.class.getName();

	private final Handler mNavigationHandler = new Handler();

	private String mode = "girls";
	private Face leftFace;
	private Face rightFace;
	private int[] faceIdArrayToNextPage;
	private boolean isInternet = false;

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.main);

		// Hide top system bar.
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);

		showMain();

		checkInternet();

		Log.v(TAG, "MainActivity created!");
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the about items for use in the action bar
		MenuInflater inflater = getMenuInflater();
		inflater.inflate(R.menu.main, menu);
		return super.onCreateOptionsMenu(menu);
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle presses on the action bar items
		switch (item.getItemId()) {
			case R.id.action_about:
				openAbout();
				return true;
			case R.id.action_top100:
				openTop100();
				return true;
			default:
				return super.onOptionsItemSelected(item);
		}
	}

	private void openAbout() {
		if (isInternet) {
			Intent intent = new Intent(this, AboutActivity.class);
			startActivity(intent);
		} else {
			showNetworkAlert();
		}
	}

	private void openTop100() {
		if (isInternet) {
			Intent intent = new Intent(this, Top100Activity.class);
			startActivity(intent);
		} else {
			showNetworkAlert();
		}
	}

	private void showMain() {
		int[] shuffleFaceIdArray;
		Map<Long, Face> faceMap;
		if ("girls".equalsIgnoreCase(mode)) {
			shuffleFaceIdArray = SortAndShuffle.shuffleArray(Base.getGirlsFaceIdArray());
			faceMap = Base.getGirlsFaceMap();
		} else {
			shuffleFaceIdArray = SortAndShuffle.shuffleArray(Base.getBoysFaceIdArray());
			faceMap = Base.getBoysFaceMap();
		}

		if (shuffleFaceIdArray.length > 1) {
			Long leftFaceId = (long) shuffleFaceIdArray[0];
			Long rightFaceId = (long) shuffleFaceIdArray[1];

			leftFace = faceMap.get(leftFaceId);
			rightFace = faceMap.get(rightFaceId);

			faceIdArrayToNextPage = Arrays.copyOfRange(shuffleFaceIdArray, 2,
					shuffleFaceIdArray.length);
		}

		updateFaces();
	}

	private void leftFace() {
		prepareNextFaces("left");
		updateFaces();
	}

	private void rightFace() {
		prepareNextFaces("right");
		updateFaces();
	}

	private void sendDataToServer(String leftOrRight) {
		Map<String, String> paramsMap = new HashMap<String, String>(8);

		paramsMap.put("hash", leftFace.getId().toString() + Constants.SOLT + rightFace.getId().toString());
		paramsMap.put("leftId", leftFace.getId().toString());
		paramsMap.put("rightId", rightFace.getId().toString());
		paramsMap.put("mode", mode);
		paramsMap.put("leftOrRight", leftOrRight);

		new HTTPPostRequest(Constants.SERVER_UPDATE_FACES_URL, paramsMap).execute();
	}

	private void prepareNextFaces(final String leftOrRight) {
		sendDataToServer(leftOrRight);

		Map<Long, Face> faceMap;
		if ("girls".equalsIgnoreCase(mode)) {
			faceMap = Base.getGirlsFaceMap();
		} else {
			faceMap = Base.getBoysFaceMap();
		}

		Long leftFaceId = (long) faceIdArrayToNextPage[0];
		Long rightFaceId = (long) faceIdArrayToNextPage[1];

		leftFace = faceMap.get(leftFaceId);
		rightFace = faceMap.get(rightFaceId);

		faceIdArrayToNextPage = Arrays.copyOfRange(faceIdArrayToNextPage, 2,
				faceIdArrayToNextPage.length);

		if (faceIdArrayToNextPage.length < 4) {
			if ("girls".equalsIgnoreCase(mode)) {
				faceIdArrayToNextPage = SortAndShuffle.shuffleArray(Base.getGirlsFaceIdArray());
			} else {
				faceIdArrayToNextPage = SortAndShuffle.shuffleArray(Base.getBoysFaceIdArray());
			}
			findViewById(R.id.messageTextView).setVisibility(View.VISIBLE);
		} else {
			findViewById(R.id.messageTextView).setVisibility(View.INVISIBLE);
		}
	}

	private void updateFaces() {
		int id = getResources().getIdentifier(leftFace.getPathToImage(), "drawable", getPackageName());
		ImageView imageView = (ImageView)findViewById(R.id.leftImageView);
		imageView.setImageResource(id);
		TextView textView = (TextView)findViewById(R.id.leftTextView);
		String name = leftFace.getFirstName();
		if (name != null) {
			textView.setText(name + " " + leftFace.getLastName());
		} else {
			textView.setText(leftFace.getLastName());
		}

		id = getResources().getIdentifier(rightFace.getPathToImage(), "drawable", getPackageName());
		imageView = (ImageView)findViewById(R.id.rightImageView);
		imageView.setImageResource(id);
		textView = (TextView)findViewById(R.id.rightTextView);
		name = rightFace.getFirstName();
		if (name != null) {
			textView.setText(name + " " + rightFace.getLastName());
		} else {
			textView.setText(rightFace.getLastName());
		}
	}

	public void onLeftClick(View v) {
		v.startAnimation(AnimationUtils.loadAnimation(this, R.anim.click));
		mNavigationHandler.postDelayed(new Runnable() {
			public void run() {
				leftFace();
			}
		}, 300);
	}

	public void onRightClick(View v) {
		v.startAnimation(AnimationUtils.loadAnimation(this, R.anim.click));
		mNavigationHandler.postDelayed(new Runnable() {
			public void run() {
				rightFace();
			}
		}, 300);
	}

	public void onNextClick(View v) {
		v.startAnimation(AnimationUtils.loadAnimation(this, R.anim.click));
		mNavigationHandler.postDelayed(new Runnable() {
			public void run() {
				showMain();
			}
		}, 300);
	}

	public void onCelebritiesBoysClick(View v) {
		v.startAnimation(AnimationUtils.loadAnimation(this, R.anim.click));
		mNavigationHandler.postDelayed(new Runnable() {
			public void run() {
				mode = "boys";
				showMain();
			}
		}, 300);
	}

	public void onCelebritiesGirlsClick(View v) {
		v.startAnimation(AnimationUtils.loadAnimation(this, R.anim.click));
		mNavigationHandler.postDelayed(new Runnable() {
			public void run() {
				mode = "girls";
				showMain();
			}
		}, 300);
	}

	public void checkInternet() {
		NetworkConnection.checkInternet(this);
	}

	public void setIsInternet(boolean isInternet) {
		this.isInternet = isInternet;
		if (!isInternet) {
			showNetworkAlert();
		}
	}

	public void showNetworkAlert() {
		new AlertDialog.Builder(this)
				.setTitle("Network connection")
				.setMessage("You must be connected to the Internet to use this app.")
				.setPositiveButton("OK", new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) {
						checkInternet(); // again
					}
				})
				.show();
	}
}
