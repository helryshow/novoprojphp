create database gastos;
use gastos;

CREATE TABLE despesas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(255) NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    data_regis TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    valor DECIMAL(10,2) NOT NULL,
    tipo_despesa VARCHAR(50) NOT NULL
);
alter table despesas
change data_regis data TIMESTAMP DEFAULT CURRENT_TIMESTAMP;
select*from despesas;

select sum(valor) from despesas;
alter table despesas
add column transferencia decimal(10,2) after tipo_despesa;
alter table despesas
drop column valor;
alter table despesas
add valor decimal(10,2) after data;
truncate table despesas;
select * from despesas;
