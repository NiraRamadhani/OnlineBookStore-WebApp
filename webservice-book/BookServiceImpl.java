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

@WebService(endpointInterface = "com.probooks.jaxws.service.BookService")  
public class BookServiceImpl implements BookService {

  @Override
  public boolean addTransaksi(Transaksi t) throws IOException{
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
			System.out.println(response.toString());
      return true;
		} else {
			System.out.println("POST request not worked");
      return false;
		}
  }

  @Override
	public String[] searchBook(String term) throws IOException{
    String USER_AGENT = "Mozilla/5.0";
    String GET_URL = "https://www.googleapis.com/books/v1/volumes?q=intitle:"+ term;

    URL obj = new URL(GET_URL);
		HttpURLConnection con = (HttpURLConnection) obj.openConnection();
		con.setRequestMethod("GET");
		con.setRequestProperty("User-Agent", USER_AGENT);
		int responseCode = con.getResponseCode();
		System.out.println("GET Response Code :: " + responseCode);
		if (responseCode == HttpURLConnection.HTTP_OK) { // success
			BufferedReader in = new BufferedReader(new InputStreamReader(
					con.getInputStream()));
			String inputLine;
			StringBuffer response = new StringBuffer();

			while ((inputLine = in.readLine()) != null) {
				response.append(inputLine);
			}
			in.close();

			// print result
			System.out.println(response.toString());
		} else {
			System.out.println("GET request not worked");
		}
  		int books_count = 1;
  		String[] bookIDs = new String[books_count];
  		return bookIDs;
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
