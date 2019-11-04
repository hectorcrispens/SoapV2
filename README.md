# SoapV2
SoapV2, es un proxy para un servicio Soap, con la finalidad de escanear el tráfico entre dos sistemas.
Se coloca entre medio de ambos, y mientras persiste el request obtenido y enviado por el primer sistemas, reenvia el mismo al segundo sistema. Cuando el response llega, el mismo es persistido en una base de datos y remitido al sistema original.
