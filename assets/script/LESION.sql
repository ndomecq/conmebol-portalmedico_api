CREATE SCHEMA [lesion]
GO

CREATE TABLE [lesion].[LESFIC](
	[LESFICCOD] [int] IDENTITY(1,1) NOT NULL,
	[LESFICESC] [int] NOT NULL, --ESTADO
    [LESFICCOC] [int] NOT NULL, --COMPETENCIA
    [LESFICJUC] [int] NOT NULL, --JUEGO
    [LESFICEQC] [int] NOT NULL, --EQUIPO
    [LESFICPEC] [int] NOT NULL, --JUGADOR
    [LESFICFEC] [datetime] NOT NULL, --FECHA
    [LESFICCLI] [int] NULL, --CLIMA 
    [LESFICTEM] [decimal](3,2) NULL, --TEMPERATURA
    [LESFICDIS] [int] NULL, --DISTANCIA (EN CASA/ SIN VIAJE - HASTA 500KM - ENTRE 500KM Y 800KM - +800KM)
    [LESFICTRA] [int] NULL, --TRANSLADO (BUS - BUS Y AVION - AVION - TREN)
    [LESFICPOS] [int] NULL, --POSICION (PORTERO - DEFENSA - LATERAL DERECHO - LATERAL IZQUIERDO - VOLANTE - CENTROCAMPISTA - DELANTERO)
    [LESFICMIN] [int] NULL, --MINUTO
    [LESFICCAM] [int] NULL, --CAMPO
    [LESFICCUZ] [int] NULL, --CUERPO ZONA (IZQUIERDO - DERECHO - NO SE APLICADA)
    [LESFICCUL] [int] NULL, --CUERPO LUGAR
    [LESFICLES] [int] NULL, --LESION TIPO ()
    [LESFICORI] [int] NULL, --LESION ESTADO (SOBRE CARGA - TRAUMA)
    [LESFICREI] [int] NULL, --LESION REINCIDENCIA (NO - SI - SIN INFORMACION)
    [LESFICCAU] [int] NULL, --LESION CAUSA (OTRO JUGADOR - CON PELOTA - CON POSTE - OTRO)
    [LESFICFAL] [int] NULL, --FALTA SANCION (TARJETA AMARILLA - TARJETA ROJA - NINGUNA)
    [LESFICDIA] [int] NULL, --DIAGNOSTICO TIPO
    [LESFICREC] [int] NULL, --DIAGNOSTICO RECUPERACION
    [LESFICTIE] [int] NULL, --DIAGNOSTICO TIEMPO (DIAS - SEMANAS - MESES)
    [LESFICOBS] [varchar](5120) NULL, --DIAGNOSTICO OBSERVACION
    [LESFICAUS] [char](50) NOT NULL,
	[LESFICAFH] [datetime] NOT NULL,
	[LESFICAIP] [char](20) NOT NULL,
 CONSTRAINT [PK_LESFICCOD] PRIMARY KEY CLUSTERED ([LESFICCOD] ASC) WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]) ON [PRIMARY]
GO

ALTER TABLE [lesion].[LESFIC] WITH CHECK ADD CONSTRAINT [FK_LESFIC_LESFICESC] FOREIGN KEY([LESFICESC]) REFERENCES [adm].[DOMFIC] ([DOMFICCOD])
GO
ALTER TABLE [lesion].[LESFIC] CHECK CONSTRAINT [FK_LESFIC_LESFICESC]
GO

ALTER TABLE [lesion].[LESFIC] WITH CHECK ADD CONSTRAINT [FK_LESFIC_LESFICCOC] FOREIGN KEY([LESFICCOC]) REFERENCES [comet].[competitions] ([competitionFifaId])
GO
ALTER TABLE [lesion].[LESFIC] CHECK CONSTRAINT [FK_LESFIC_LESFICCOC]
GO

ALTER TABLE [lesion].[LESFIC] WITH CHECK ADD CONSTRAINT [FK_LESFIC_LESFICJUC] FOREIGN KEY([LESFICJUC]) REFERENCES [comet].[matches] ([matchFifaId])
GO
ALTER TABLE [lesion].[LESFIC] CHECK CONSTRAINT [FK_LESFIC_LESFICJUC]
GO

ALTER TABLE [lesion].[LESFIC] WITH CHECK ADD CONSTRAINT [FK_LESFIC_LESFICEQC] FOREIGN KEY([LESFICEQC]) REFERENCES [comet].[teams] ([teamFifaId])
GO
ALTER TABLE [lesion].[LESFIC] CHECK CONSTRAINT [FK_LESFIC_LESFICEQC]
GO

ALTER TABLE [lesion].[LESFIC] WITH CHECK ADD CONSTRAINT [FK_LESFIC_LESFICPEC] FOREIGN KEY([LESFICPEC]) REFERENCES [comet].[persons] ([personFifaId])
GO
ALTER TABLE [lesion].[LESFIC] CHECK CONSTRAINT [FK_LESFIC_LESFICPEC]
GO