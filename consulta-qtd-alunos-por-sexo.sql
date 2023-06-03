/*
Consulta que retorna a quantidade de alunos agrupados por cd_sexo
*/
select cd_sexo, count(*) as qtd
from tb_pessoa
group by cd_sexo;