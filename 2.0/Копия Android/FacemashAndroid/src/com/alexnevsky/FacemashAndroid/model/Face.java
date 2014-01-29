package com.alexnevsky.FacemashAndroid.model;

/**
 * User: Alex Nevsky
 * Date: 08.10.13
 */
public class Face implements Comparable<Face> {

	private static long idCount;

	private Long id;
	private String firstName;
	private String lastName;
	private String pathToImage;
	private volatile Integer rating;

	{
		idCount += 1;
		id = idCount;
		rating = 1400;
	}

	public Face() {
	}

	public Face(String firstName, String lastName) {
		this.firstName = firstName;
		this.lastName = lastName;
	}

	public Face(String firstName, String lastName, String pathToImage) {
		this.firstName = firstName;
		this.lastName = lastName;
		this.pathToImage = pathToImage;
	}

	public Long getId() {
		return id;
	}

	public String getFirstName() {
		return firstName;
	}

	public String getLastName() {
		return lastName;
	}

	public String getPathToImage() {
		return pathToImage;
	}

	public Integer getRating() {
		return rating;
	}

	@Override
	public boolean equals(Object o) {
		if (this == o) return true;
		if (o == null || getClass() != o.getClass()) return false;

		Face face = (Face) o;

		if (!id.equals(face.id)) return false;

		return true;
	}

	@Override
	public int hashCode() {
		return id.hashCode();
	}

	@Override
	public String toString() {
		return "Face{" +
				"id=" + id +
				", firstName='" + firstName + '\'' +
				", lastName='" + lastName + '\'' +
				", pathToImage='" + pathToImage + '\'' +
				", rating=" + rating +
				'}';
	}

	@Override
	public int compareTo(Face f) {
		return f.getRating() - getRating();
	}
}