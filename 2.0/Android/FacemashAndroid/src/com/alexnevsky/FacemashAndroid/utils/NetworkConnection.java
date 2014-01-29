package com.alexnevsky.FacemashAndroid.utils;

import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;

import java.util.Collections;

/**
 * User: Alex Nevsky
 * Date: 05.11.13
 */
public class NetworkConnection {

	public static boolean isOnline() {
		ConnectivityManager cm = (ConnectivityManager) MyApplication.getAppContext().getSystemService(Context
				.CONNECTIVITY_SERVICE);

		if (cm.getActiveNetworkInfo() != null && cm.getActiveNetworkInfo().isConnectedOrConnecting()) {
		NetworkInfo i = cm.getActiveNetworkInfo();
		if (i == null)
			return false;
		if (!i.isConnected())
			return false;
		if (!i.isAvailable())
			return false;
		return true;
		} else {
			return false;
		}
	}

	public static void checkInternet(InternetRequirable internetRequirable) {
		if (isOnline()) {
			new HTTPPostRequest(Constants.GOOGLE_URL, Collections.<String, String>emptyMap(), internetRequirable).execute();
		} else {
			internetRequirable.setIsInternet(false);
		}
	}
}
