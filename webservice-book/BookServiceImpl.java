package com.probooks.jaxws.service;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import javax.jws.WebService;

import java.sql.*;
import com.probooks.jaxws.beans.Book;
import com.probooks.jaxws.beans.Transaksi;
import org.json.JSONObject; 
import org.json.JSONArray;

@WebService(endpointInterface = "com.probooks.jaxws.service.BookService")  
public class BookServiceImpl implements BookService {

  @Override
  public boolean pembelian(Transaksi t, Book b) throws IOException{
    String USER_AGENT = "Mozilla/5.0";
    String POST_URL = "http://localhost:3000/transfer";
    String POST_PARAMS = "nomorPengirim="+t.getNomorPengirim()+"&nomorPenerima="+t.getNomorPenerima()+"&jumlah="+t.getJumlah();
    URL obj = new URL(POST_URL);
		HttpURLConnection con = (HttpURLConnection) obj.openConnection();
		con.setRequestMethod("POST");
		con.setRequestProperty("User-Agent", USER_AGENT);

		// For POST only - START
		con.setDoOutput(true);
		OutputStream os = con.getOutputStream();
		os.write(POST_PARAMS.getBytes());
		os.flush();
		os.close();
		// For POST only - END

		int responseCode = con.getResponseCode();
		System.out.println("POST Response Code :: " + responseCode);

		if (responseCode == HttpURLConnection.HTTP_OK) { //success
			BufferedReader in = new BufferedReader(new InputStreamReader(
					con.getInputStream()));
			String inputLine;
			StringBuffer response = new StringBuffer();

			while ((inputLine = in.readLine()) != null) {
				response.append(inputLine);
			}
			in.close();

			// print result
			System.out.println(response);
			if(response.toString().equals("true")){
				// Insert to DB successfull
				String query ="INSERT INTO orderbook(bookid, kategori, jumlah)" + "VALUES(?, ?, ?)";
				System.out.println(query);
				try{  
					Class.forName("com.mysql.cj.jdbc.Driver");  
					Connection conDB = DriverManager.getConnection(
						"jdbc:mysql://localhost:3306/bookservice",
						"root",""
					);   
					PreparedStatement preparedStmt = conDB.prepareStatement(query);
					preparedStmt.setString(1, b.getId());
					preparedStmt.setString(2, b.getKategori());
					preparedStmt.setFloat(3, t.getJumlah()/b.getHarga());
					preparedStmt.execute();
					conDB.close();  
				}catch(Exception e){System.out.println(e);}				
			}else{
				
			}
      return true;
		} else {
			System.out.println("POST request not worked");
      return false;
		}
  }

  @Override
	public Book[] searchBook(String term) throws IOException{
    String USER_AGENT = "Mozilla/5.0";
    String GET_URL = "https://www.googleapis.com/books/v1/volumes?q=intitle:"+term;

    term = term.replace(" ", "+");
    URL obj = new URL(GET_URL);
		HttpURLConnection con = (HttpURLConnection) obj.openConnection();
		con.setRequestMethod("GET");
		con.setRequestProperty("User-Agent", USER_AGENT);
		int responseCode = con.getResponseCode();
		System.out.println("GET Response Code :: " + responseCode);
		StringBuffer response = new StringBuffer();
		if (responseCode == HttpURLConnection.HTTP_OK) { // success
			BufferedReader in = new BufferedReader(new InputStreamReader(
					con.getInputStream()));
			String inputLine;
			

			while ((inputLine = in.readLine()) != null) {
				response.append(inputLine);
			}
			in.close();

			// print result
			//System.out.println("Result: ");
			//System.out.println(response.toString());
		} else {
			System.out.println("GET request not worked");
		}

		JSONObject json = new JSONObject(response.toString());
	  	
  		int books_count = json.getJSONArray("items").length();
  		Book[] books = new Book[books_count];
  		
  		for (int i = 0; i < books_count; i++) {
  			books[i] = new Book();
  			books[i].setId(json.getJSONArray("items").getJSONObject(i).getString("id"));
  			books[i].setJudul(json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").getString("title"));
  			
  			//penulis
  			if (json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").has("authors")) {
				JSONArray authors_array = json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").getJSONArray("authors");
	  			String[] authors = new String[authors_array.length()];
	  			for (int j = 0; j < authors_array.length(); j++) {
	  				authors[j] = authors_array.getString(j);
	  			}
	  			books[i].setPenulis(authors);  				
  			} else {
  				String[] anon = new String[1];
  				anon[0] = "Anonymous";
  				books[i].setPenulis(anon);
  			}
  			
  			//deskripsi
  			if (json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").has("description")) {
 				books[i].setSinopsis(json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").getString("description"));
  			} else {
  				books[i].setSinopsis("No description");
  			}
  			
  			//gambar
  			if (json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").has("imageLinks")) {
  				books[i].setGambar(json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").getJSONObject("imageLinks").getString("thumbnail"));
  			} else {
  				books[i].setGambar("No Image");
  			}

  			//harga
			if (json.getJSONArray("items").getJSONObject(i).getJSONObject("saleInfo").has("listPrice")) {
  				books[i].setHarga(json.getJSONArray("items").getJSONObject(i).getJSONObject("saleInfo").getJSONObject("listPrice").getFloat("amount"));
  			} else {
  				books[i].setHarga(0);
  			}

  			//votes
  			if (json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").has("ratingsCount")) {
  				books[i].setVotesCount(json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").getInt("ratingsCount"));	
  			} else {
  				books[i].setVotesCount(0);
  			}

  			//average rating
 			if (json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").has("averageRating")) {
  				books[i].setRating(json.getJSONArray("items").getJSONObject(i).getJSONObject("volumeInfo").getFloat("averageRating"));	
  			} else {
  				books[i].setRating(0);
  			}

  			//kategori
  			

  		}
  		return books;
  }

	@Override
	public String getDetail(String id){
		return id;
	};

	@Override
	public String getRecommendation(String kategori){
		String query = String.format("SELECT orders.orderid, orders.bookid, orders.kategori, orders.total FROM (SELECT *, sum(jumlah) total FROM orderbook WHERE kategori = '%s' GROUP BY bookid) orders WHERE orders.total = (SELECT Max(total) FROM(SELECT sum(jumlah) total FROM orderbook WHERE kategori = '%s' GROUP BY bookid) jumlahbook)" , kategori, kategori);
		int orderid;
		String idbook = "0";
		int total;
		try{  
      Class.forName("com.mysql.cj.jdbc.Driver");  
      Connection con = DriverManager.getConnection(
				"jdbc:mysql://localhost:3306/bookservice",
				"root",""
			);   
      Statement stmt = con.createStatement();  
      ResultSet rs = stmt.executeQuery(query);
      while(rs.next()){
				orderid = rs.getInt(1);
				idbook = rs.getString(2);
				kategori = rs.getString(3);
				total = rs.getInt(4);
				System.out.println(orderid + "  " + idbook + "  " + kategori + " " + total);
			}  
      con.close();  
    }catch(Exception e){System.out.println(e);}
		return idbook;
	};
}
