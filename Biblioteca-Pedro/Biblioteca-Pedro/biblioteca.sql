-- Create table (livros)
CREATE TABLE livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    ano_publicacao YEAR NOT NULL
);

-- Create table (socios)
CREATE TABLE socios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(15) NOT NULL,
    endereco TEXT NOT NULL,
    data_nascimento DATE NOT NULL
);

-- Create table  (retiradas)
CREATE TABLE retiradas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    livro_id INT NOT NULL,
    socio_id INT NOT NULL,
    data_retirada DATE NOT NULL,
    data_devolucao DATE NOT NULL,
    FOREIGN KEY (livro_id) REFERENCES livros(id),
    FOREIGN KEY (socio_id) REFERENCES socios(id)
);


INSERT INTO livros (isbn, titulo, autor, categoria, ano_publicacao) 
VALUES
('978-3-16-148410-0', 'A História da Biblioteca', 'José Silva', 'História', 2005),
('978-1-23-456789-0', 'O Mundo das Ideias', 'Maria Oliveira', 'Filosofia', 2010),
('978-0-12-345678-9', 'Tecnologias do Futuro', 'Carlos Souza', 'Tecnologia', 2020);


INSERT INTO socios (nome, email, telefone, endereco, data_nascimento) 
VALUES
('João da Silva', 'joao.silva@email.com', '9999-8888', 'Rua A, 123', '1985-06-15'),
('Maria Oliveira', 'maria.oliveira@email.com', '9999-7777', 'Rua B, 456', '1990-07-22'),
('Carlos Souza', 'carlos.souza@email.com', '9999-6666', 'Rua C, 789', '1982-10-30');


INSERT INTO retiradas (livro_id, socio_id, data_retirada, data_devolucao)
VALUES
(1, 1, '2024-11-01', '2024-11-15'),
(2, 2, '2024-11-05', '2024-11-20'),
(3, 3, '2025-11-10', '2025-11-25');


-- Create table  `superior`


CREATE TABLE `superior` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Create table  `superior`


CREATE TABLE `superior` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Despejando dados para a tabela `superior`



INSERT INTO `superior` (`id`, `username`, `password`) VALUES
(1, 'usuario', '123'),
(2, 'Pedro', '123456'),
(3, 'Admin', 'admin');


-- Índices de tabela `superior`


ALTER TABLE `superior`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);


-- AUTO_INCREMENT de tabela `superior`

ALTER TABLE `superior`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--