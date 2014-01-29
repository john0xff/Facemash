package com.alexnevsky.FacemashAndroid.utils;

import java.util.Random;

/**
 * User: Alex Nevsky
 * Date: 08.10.13
 */
public class SortAndShuffle {

	// Implementing Fisher–Yates shuffle
	public static int[] shuffleArray(int[] array) {
		Random rnd = new Random();
		for (int i = array.length - 1; i > 0; i--) {
			int index = rnd.nextInt(i + 1);
			// Simple swap
			int a = array[index];
			array[index] = array[i];
			array[i] = a;
		}
		return array;
	}
}
