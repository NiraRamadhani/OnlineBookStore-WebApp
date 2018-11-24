package com.probooks.jaxws.service;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import javax.jws.WebService;


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
	public String searchBook(String term){
    System.out.print(term);
    return term;
  };

	@Override
	public String getDetail(String id){
		return id;
	};

	@Override
	public String getRecommendation(String kategori){
		return kategori;
	};
}
