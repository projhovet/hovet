use dbhovetTeste;

create table tipos_movimentacao(
	id int primary key auto_increment,
    tipo varchar(256),
    Descricao varchar(256)
);

insert into tipos_movimentacao values
	(null,"Inserção", "Inserção de insumo(s) no estoque."),
    (null,"Retirada", "Retirada de insumo(s) do estoque."),
    (null,"Doação", "Doação de insumo(s) que irão para o estoque."),
    (null,"Permuta", "Troca de insumo(s) do estoque com outras instituições.");
    
select * from tipos_movimentacao;

#################################################################################

## Depósito ##

create table setores (
	id int primary key auto_increment,
    setor varchar(100) not null
);

insert into setores values
	(null, 'Clínica'),
    (null, 'Anestesia'),
    (null, 'Grandes Animais');
    
#drop table setores;
    
create table deposito(
	deposito_id int primary key auto_increment,
    deposito_Qtd int not null,
    deposito_Validade date not null,
    deposito_InsumosID int not null,
	foreign key(deposito_InsumosID) references insumos(id)
);

insert into deposito values 
	(null, 20, '2023-04-05', 1),
    (null, 10, '2023-04-09', 3);


SELECT 
	count(id) as vencidos
    FROM deposito where validade<=curdate() or validade <= curdate() + interval 30 day;
    
select * from deposito;

SELECT
	d.deposito_id,
	i.nome,
    d.deposito_Qtd,
    date_format(d.deposito_Validade, '%d/%m/%Y') AS validade,
    datediff(d.deposito_Validade, curdate()) as diasParaVencimento
	FROM deposito AS d 
    INNER JOIN insumos AS i
    ON d.deposito_id = i.id;

drop table deposito;


create table dispensario(
	dispensario_id int primary key auto_increment,
    dispensario_Qtd int not null,
    dispensario_Validade date not null,
    dispensario_InsumosID int not null,
	foreign key(dispensario_InsumosID) references insumos(id),
    dispensario_localId int not null,
    foreign key(dispensario_localId) references local_dispensario(local_id)
);

insert into dispensario values 
	(null, 20, '2023-04-05', 1, 1),
    (null, 10, '2023-04-09', 3, 2);
    
select * from dispensario;

create table local_dispensario (
	local_id int primary key not null auto_increment,
    local_nome varchar (20) not null
);
drop table local_dispensario;
insert into local_dispensario values
	(null, 'Armário'),
	(null, 'Estante'),
	(null, 'Gaveteiro');

delete from dispensario where dispensario_id = 2;


SELECT
	d.dispensario_id,
	d.dispensario_Qtd,
	date_format(d.dispensario_Validade, '%d/%m/%Y') as validadeDispensario,
    i.nome,
    datediff(d.dispensario_Validade, curdate()) as diasParaVencimentoDispensario,
    lcd.local_nome
	FROM dispensario d 
    INNER JOIN insumos i 
    ON d.dispensario_InsumosID = i.id
    INNER JOIN local_dispensario lcd 
    ON d.dispensario_localId = lcd.local_id;
    

create table armario(
	armario_id int primary key not null,
    nome varchar (20) not null,
    foreign key(id_armario_dispensarioId) references dispensario(dispensario_id)
	);
    
insert into armario values 
	(1);
    
select * from armario a 
	inner join dispensario dis
    on a.id_armario_dispensarioId = dis.dispensario_id;


create table estante(
	estante_id int primary key not null,
    nome varchar (20) not null,
	id_dispensarioId int not null,
    foreign key(id_estante_dispensarioId) references dispensario(dispensario_id)
	);
    
insert into estante value (2);

select * from estante e 
	inner join dispensario dis
    on e.id_estante_dispensarioId = dis.dispensario_id;
    
create table gaveteiro (
	gaveteiro_id int primary key not null,
    inicial varchar (10) not null,
    id_estanteId_dispensarioId int not null,
    foreign key (id_gaveteiro_estanteId) references estante(id_dispensarioId));
    
insert into gaveteiro value (2);

select * from gaveteiro;

select * from gaveteiro g inner join dispensario dis on g.id_gaveteiro_estanteId = dis.dispensario_id;

select * from dispensario;

delete from dispensario where dispensario_id=4;


SELECT
	dep.deposito_InsumosID,
    dep.deposito_Validade,
    dep.deposito_Qtd,
    ins.nome 
	FROM deposito dep 
    INNER JOIN insumos ins 
    ON dep.deposito_InsumosID = ins.id;
    
select * from deposito;

update deposito dep 
	inner join dispensario disp 
    set 
		dep.deposito_Qtd = dep.deposito_Qtd-disp


select sum(quantidade) from deposito WHERE nome like '%mela%' or id=2;
