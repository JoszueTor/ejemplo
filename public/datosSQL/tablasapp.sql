--MUNICION SITUACION

CREATE TABLE 615351.municion_situacion  ( 
	id         	SERIAL NOT NULL,
	descripcion	VARCHAR(150) NOT NULL,
	situacion  	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO

--MUNICION ORGANIZACION
CREATE TABLE 615617.municion_organizacion  ( 
	id            	SERIAL NOT NULL,
	id_dependencia	INTEGER,
	jerarquia     	INTEGER,
	nombre        	VARCHAR(100),
	situacion     	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO

--MUNICION LOTE

CREATE TABLE 615351.municion_lote  ( 
	id         	SERIAL NOT NULL,
	descripcion	VARCHAR(150) NOT NULL,
	situacion  	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO


--MUNICION INGRESOFAB

CREATE TABLE 615351.municion_ingresofab  ( 
	id            	SERIAL NOT NULL,
	lote          	INTEGER,
	calibre       	INTEGER,
	cantidad      	INTEGER,
	motivo        	INTEGER,
	documento     	VARCHAR(150),
	observaciones 	VARCHAR(250),
	movimiento    	SMALLINT,
	fecha         	DATETIME YEAR to MINUTE,
	departamento  	SMALLINT,
	catalogo      	INTEGER NOT NULL,
	catalogosalida	INTEGER NOT NULL,
	situacion     	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO
ALTER TABLE 615351.municion_ingresofab
	ADD CONSTRAINT ( FOREIGN KEY(catalogo)
	REFERENCES informix.mper(per_catalogo) CONSTRAINT r4249_23488
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresofab
	ADD CONSTRAINT ( FOREIGN KEY(departamento)
	REFERENCES informix.mdep(dep_llave) CONSTRAINT r4249_23217
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresofab
	ADD CONSTRAINT ( FOREIGN KEY(motivo)
	REFERENCES 615351.municion_situacion(id) CONSTRAINT r4249_23216
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresofab
	ADD CONSTRAINT ( FOREIGN KEY(calibre)
	REFERENCES 615351.municion_calibre(id) CONSTRAINT r4249_23215
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresofab
	ADD CONSTRAINT ( FOREIGN KEY(lote)
	REFERENCES 615351.municion_lote(id) CONSTRAINT r4249_23214
	ENABLED )
GO

--MUNICION INGRESOALMACEN

CREATE TABLE 615351.municion_ingresoalmacen  ( 
	id            	SERIAL NOT NULL,
	lote          	INTEGER,
	calibre       	INTEGER,
	cantidad      	INTEGER,
	motivo        	INTEGER,
	documento     	VARCHAR(150),
	observaciones 	VARCHAR(250),
	movimiento    	SMALLINT,
	fecha         	DATETIME YEAR to MINUTE,
	departamento  	SMALLINT,
	catalogo      	INTEGER,
	catalogosalida	INTEGER,
	situacion     	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO
ALTER TABLE 615351.municion_ingresoalmacen
	ADD CONSTRAINT ( FOREIGN KEY(catalogo)
	REFERENCES informix.mper(per_catalogo) CONSTRAINT r4254_23489
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresoalmacen
	ADD CONSTRAINT ( FOREIGN KEY(departamento)
	REFERENCES informix.mdep(dep_llave) CONSTRAINT r4254_23237
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresoalmacen
	ADD CONSTRAINT ( FOREIGN KEY(motivo)
	REFERENCES 615351.municion_situacion(id) CONSTRAINT r4254_23236
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresoalmacen
	ADD CONSTRAINT ( FOREIGN KEY(calibre)
	REFERENCES 615351.municion_calibre(id) CONSTRAINT r4254_23235
	ENABLED )
GO
ALTER TABLE 615351.municion_ingresoalmacen
	ADD CONSTRAINT ( FOREIGN KEY(lote)
	REFERENCES 615351.municion_lote(id) CONSTRAINT r4254_23234
	ENABLED )
GO


--MUNICION FABRICA

CREATE TABLE 623488.municion_fabrica  ( 
	fabrica_id           	SERIAL NOT NULL,
	fabrica_lote         	SMALLINT,
	fabrica_calibre      	SMALLINT,
	fabrica_cantidad     	INTEGER,
	fabrica_destino      	SMALLINT,
	fabrica_documento    	CHAR(100),
	fabrica_observaciones	CHAR(200),
	fabrica_movimiento   	CHAR(10),
	fabrica_fecha        	DATETIME YEAR to MINUTE,
	fabrica_dep          	SMALLINT,
	fabrica_situacion    	SMALLINT,
	PRIMARY KEY(fabrica_id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO


--MUNICION CALIBRE

CREATE TABLE 615351.municion_calibre  ( 
	id         	SERIAL NOT NULL,
	descripcion	VARCHAR(150) NOT NULL,
	situacion  	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO




-- MUNICION BATALLON

CREATE TABLE 615617.municion_batallon  ( 
	id            	SERIAL NOT NULL,
	lote          	INTEGER,
	calibre       	INTEGER,
	cantidad      	INTEGER,
	motivo        	INTEGER,
	documento     	VARCHAR(150),
	observaciones 	VARCHAR(250),
	movimiento    	SMALLINT,
	fecha         	DATETIME YEAR to MINUTE NOT NULL,
	departamento  	SMALLINT,
	batallon      	SMALLINT,
	catalogo      	INTEGER,
	catalogosalida	INTEGER,
	situacion     	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO
ALTER TABLE 615617.municion_batallon
	ADD CONSTRAINT ( FOREIGN KEY(catalogosalida)
	REFERENCES informix.mper(per_catalogo) CONSTRAINT r4373_23516
	ENABLED )
GO
ALTER TABLE 615617.municion_batallon
	ADD CONSTRAINT ( FOREIGN KEY(catalogo)
	REFERENCES informix.mper(per_catalogo) CONSTRAINT r4373_23515
	ENABLED )
GO
ALTER TABLE 615617.municion_batallon
	ADD CONSTRAINT ( FOREIGN KEY(departamento)
	REFERENCES informix.mdep(dep_llave) CONSTRAINT r4373_23514
	ENABLED )
GO
ALTER TABLE 615617.municion_batallon
	ADD CONSTRAINT ( FOREIGN KEY(motivo)
	REFERENCES 615351.municion_situacion(id) CONSTRAINT r4373_23513
	ENABLED )
GO
ALTER TABLE 615617.municion_batallon
	ADD CONSTRAINT ( FOREIGN KEY(calibre)
	REFERENCES 615351.municion_calibre(id) CONSTRAINT r4373_23512
	ENABLED )
GO
ALTER TABLE 615617.municion_batallon
	ADD CONSTRAINT ( FOREIGN KEY(lote)
	REFERENCES 615351.municion_lote(id) CONSTRAINT r4373_23511
	ENABLED )
GO


--MUNICION ALMACEN COMANDO

CREATE TABLE 615617.municion_almacencomando  ( 
	id            	SERIAL NOT NULL,
	lote          	INTEGER,
	calibre       	INTEGER,
	cantidad      	INTEGER,
	motivo        	INTEGER,
	documento     	VARCHAR(150),
	observaciones 	VARCHAR(250),
	movimiento    	SMALLINT,
	fecha         	DATETIME YEAR to MINUTE NOT NULL,
	departamento  	SMALLINT,
	catalogo      	INTEGER,
	catalogosalida	INTEGER,
	situacion     	SMALLINT,
	PRIMARY KEY(id)
	ENABLED
)
IN mdndbs
EXTENT SIZE 16 NEXT SIZE 16 
LOCK MODE PAGE
GO
ALTER TABLE 615617.municion_almacencomando
	ADD CONSTRAINT ( FOREIGN KEY(catalogosalida)
	REFERENCES informix.mper(per_catalogo) CONSTRAINT r4371_23505
	ENABLED )
GO
ALTER TABLE 615617.municion_almacencomando
	ADD CONSTRAINT ( FOREIGN KEY(catalogo)
	REFERENCES informix.mper(per_catalogo) CONSTRAINT r4371_23504
	ENABLED )
GO
ALTER TABLE 615617.municion_almacencomando
	ADD CONSTRAINT ( FOREIGN KEY(departamento)
	REFERENCES informix.mdep(dep_llave) CONSTRAINT r4371_23503
	ENABLED )
GO
ALTER TABLE 615617.municion_almacencomando
	ADD CONSTRAINT ( FOREIGN KEY(motivo)
	REFERENCES 615351.municion_situacion(id) CONSTRAINT r4371_23502
	ENABLED )
GO
ALTER TABLE 615617.municion_almacencomando
	ADD CONSTRAINT ( FOREIGN KEY(calibre)
	REFERENCES 615351.municion_calibre(id) CONSTRAINT r4371_23501
	ENABLED )
GO
ALTER TABLE 615617.municion_almacencomando
	ADD CONSTRAINT ( FOREIGN KEY(lote)
	REFERENCES 615351.municion_lote(id) CONSTRAINT r4371_23500
	ENABLED )
GO
