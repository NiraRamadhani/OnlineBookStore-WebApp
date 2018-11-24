package com.probooks.jaxws.service;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.OutputStream;
import java.net.HttpURLConnection;
import java.net.URL;

import com.probooks.jaxws.beans.Book;
import com.probooks.jaxws.beans.Transaksi;

@WebService
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookService {
	
	@WebMethod
	public boolean addTransaksi(Transaksi t) throws IOException;

  @WebMethod
	public String searchBook(String term);

	@WebMethod
	public String getDetail(String id);

	@WebMethod
	public String getRecommendation(String kategory);

}