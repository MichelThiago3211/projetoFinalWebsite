DROP SCHEMA IF EXISTS projeto_ms;
CREATE SCHEMA IF NOT EXISTS projeto_ms;
USE projeto_ms;

CREATE TABLE IF NOT EXISTS municipio (
  id_municipio INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  estado CHAR(2) NOT NULL
);

CREATE TABLE IF NOT EXISTS fornecedor (
  id_fornecedor INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  telefone VARCHAR(11) NOT NULL,
  email VARCHAR(254) NOT NULL,
  senha CHAR(64) NOT NULL,
  cnp VARCHAR(14) NOT NULL,
  tipo BOOLEAN NOT NULL,
  imagem VARCHAR(100) NULL,
  ativo BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS ponto_coleta (
  id_ponto_coleta INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  horario VARCHAR(250) NULL,
  complemento VARCHAR(20) NOT NULL,
  numero SMALLINT NOT NULL,
  rua VARCHAR(50) NOT NULL,
  cep INT NOT NULL,
  id_municipio INT NOT NULL,
  id_fornecedor INT NOT NULL,
  referencia VARCHAR(100) NULL,
  sede BOOLEAN NOT NULL DEFAULT FALSE,
  CONSTRAINT fk_ponto_coleta_municipio FOREIGN KEY (id_municipio) REFERENCES municipio (id_municipio),
  CONSTRAINT fk_ponto_coleta_fornecedor FOREIGN KEY (id_fornecedor) REFERENCES fornecedor (id_fornecedor)
);

CREATE TABLE IF NOT EXISTS reserva (
  id_reserva INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  cpf CHAR(11) NOT NULL,
  nome VARCHAR(50) NOT NULL,
  data DATETIME(6) NOT NULL
);

CREATE TABLE IF NOT EXISTS categoria_peca (
  id_categoria_peca INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  descricao VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS peca (
  id_peca INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  tamanho VARCHAR(3) NOT NULL,
  cor VARCHAR(10) NULL,
  descricao VARCHAR(500) NULL,
  titulo VARCHAR(100) NOT NULL,
  preco INT NOT NULL,
  id_reserva INT NULL,
  id_categoria_peca INT NOT NULL,
  id_ponto_coleta INT NOT NULL,
  CONSTRAINT fk_peca_reserva FOREIGN KEY (id_reserva) REFERENCES reserva (id_reserva),
  CONSTRAINT fk_peca_categoria_peca FOREIGN KEY (id_categoria_peca) REFERENCES categoria_peca (id_categoria_peca),
  CONSTRAINT fk_peca_ponto_coleta FOREIGN KEY (id_ponto_coleta) REFERENCES ponto_coleta (id_ponto_coleta)
);

CREATE TABLE IF NOT EXISTS imagem_peca (
  id_imagem_peca INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  imagem VARCHAR(100) NOT NULL,
  id_peca INT NOT NULL,
  CONSTRAINT fk_imagem_peca_peca FOREIGN KEY (id_peca) REFERENCES peca (id_peca)
);

CREATE TABLE IF NOT EXISTS categoria_reporte (
  id_categoria_reporte INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  descricao VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS reporte (
  id_reporte INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  comentario VARCHAR(200) NOT NULL,
  id_categoria_reporte INT NOT NULL,
  id_peca INT NOT NULL,
  CONSTRAINT fk_reporte_categoria_reporte FOREIGN KEY (id_categoria_reporte) REFERENCES categoria_reporte (id_categoria_reporte),
  CONSTRAINT fk_reporte_peca FOREIGN KEY (id_peca) REFERENCES peca (id_peca)
);