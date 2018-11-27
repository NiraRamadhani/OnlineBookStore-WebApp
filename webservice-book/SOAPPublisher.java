
package com.probooks.jaxws.service;

import javax.xml.ws.Endpoint;

public class SOAPPublisher {

	public static void main(String[] args) {
		Endpoint.
		Endpoint.publish("http://localhost:8888/service/transaksi", new BookServiceImpl());
	}

}
