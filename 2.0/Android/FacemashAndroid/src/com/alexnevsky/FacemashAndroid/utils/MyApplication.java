package com.alexnevsky.FacemashAndroid.utils;

import android.app.Application;
import android.content.Context;

/**
 * User: Alex Nevsky
 * Date: 05.11.13
 */
public class MyApplication extends Application {

	private static Context context;

	public void onCreate(){
		super.onCreate();
		MyApplication.context = getApplicationContext();
	}

	public static Context getAppContext() {
		return MyApplication.context;
	}
}