SELECT orders.orderid, orders.bookid, orders.kategori, orders.total 
FROM (SELECT *, sum(jumlah) total FROM orderbook
      WHERE kategori = 'action'
      GROUP BY bookid) orders
WHERE orders.total = (SELECT Max(total)
                    FROM( SELECT sum(jumlah) total FROM orderbook 
                          WHERE kategori = 'action'
                          GROUP BY bookid
                        ) jumlahbook
                    )