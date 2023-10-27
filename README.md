# Gerenciamento de Funcionários e Pedidos

Este repositório foi desenvolvido com fins didáticos, representando um sistema de gerenciamento de funcionários e pedidos de compra, incluindo funcionalidades CRUD (Criar, Ler, Atualizar, Excluir) para funcionários e uma estrutura de banco de dados para gerenciar pedidos de compra.

## Objetivo
Desenvolver um sistema de gerenciamento de funcionários e pedidos de compra. O sistema é composto por dois módulos principais: cadastro de funcionários e controle de pedidos.

## Requisitos
* O sistema é desenvolvido utilizando FrontEnd e BackEnd (PHP8).
* Utilização do banco de dados MySQL para armazenar os dados, com opção para modelagem relacional.
* BackEnd não utiliza frameworks, seguindo princípios de POO.
* Utilização de instruções SQL para manipulação do banco de dados.

## Funcionalidades Disponíveis

### Funcionários
1. **Inserir:** Adicionar um novo funcionário ao sistema, incluindo Nome, Sobrenome, Cargo, Data de Nascimento e Salário.
2. **Alterar:** Modificar informações de um funcionário existente no sistema.
3. **Excluir:** Remover um funcionário do banco de dados.
4. **Visualizar:** Ver detalhes dos funcionários cadastrados, incluindo um aviso especial para aniversariantes do mês.

### Pedidos de Compra
1. **Inserir:** Criar um novo pedido de compra com detalhes como número do pedido, data do pedido, data de entrega, valor dos produtos, valor de desconto, valor do frete e produtos associados ao pedido.
2. **Alterar:** Modificar informações de um pedido de compra existente.
3. **Excluir:** Remover um pedido de compra do banco de dados.
4. **Visualizar:** Ver detalhes dos pedidos de compra, incluindo produtos associados e cálculos de desconto e frete conforme as regras especificadas.

## Observações
* Este projeto inclui um cenário próximo do real para rotinas comuns desenvolvidas por equipes de desenvolvedores.
* Conhecimentos de Inner Join e Left Join são essenciais para entender e trabalhar com as relações entre as tabelas.
* A passagem de parâmetros para o BackEnd é fundamental para a execução eficaz das operações.
* Um banco de dados deve ser criado com as seguintes tabelas:
  - **cad_unidade:** sigla (Primary Key), descrição.
  - **cad_grupo_produtos:** código (Primary Key), descrição.
  - **cad_produto:** cod (Primary Key), descrição, sigla_unidade (Foreign Key), cod_grupo (Foreign Key), preço.
  - **pedido_compra:** número (Primary Key), data_pedido (Primary Key), data_entrega, valor_produto, valor_desconto, valor_frete.
  - **pedido_compra_produtos:** posicao_lancamento, numero_pedido (Foreign Key), cod_prod (Foreign Key), qtde, preco, desconto, frete, valor_total.
* Registros devem ser inseridos para alimentar as tabelas conforme as regras especificadas. Após isso, relatórios devem ser criados com base nessas informações.

## Contribua

Este é um projeto feito por Nilson Filho. Para contribuir, siga as orientações abaixo:

⚠️ Resolvendo, respondendo ou indicando **issues**.

⭐ Adicionando aos favoritos (**star**).

Lembre-se, você tem o direito de realizar uma reunião com o Screem Master da Equipe para tirar dúvidas e discutir o projeto.

Aproveite e bons estudos! 🚀
