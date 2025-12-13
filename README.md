<h1 align="center">Projeto AUcolher</h1>
<p align="center">Sistema de Adoção de Animais</p>
<br>

O Projeto Aucolher tem como objetivo facilitar a adoção responsável de animais, conectando adotantes a doadores. Ele resolve a dificuldade no processo de adoção, oferecendo uma plataforma simples e acessível, promovendo a conscientização e contribuindo para a redução do abandono.
<br><br>

<h3>-Regras de Negócio (RN)</h3>
RN01 – Todo usuário deve possuir um nível de acesso definido (“usuário” ou “admin”), e o e-mail informado deve ser exclusivo no sistema.<br>
RN02– Cada animal deve estar vinculado a um usuário responsável (usuario_id) e sempre iniciar com o status “Disponível”.<br>
RN03 – Somente o dono do animal ou o administrador podem alterar ou excluir registros; animais com status “Adotado” não podem ser editados por usuários comuns.<br>
RN04 – Apenas usuários podem realizar pedidos de adoção, sendo proibida mais de uma solicitação pendente do mesmo usuário para o mesmo animal.<br>
RN05 – Somente o proprietário do animal (doador) pode aprovar ou recusar as solicitações recebidas.<br>
RN06 – Ao aprovar uma solicitação, ela deve receber status “aprovada”, o animal passa para “Adotado” e todas as demais solicitações pendentes desse animal são recusadas automaticamente.<br>
RN07 – Ao recusar uma solicitação, o sistema deve alterar seu status para “recusada” e registrar a data da resposta.<br>
RN08 – O sistema deve armazenar a data da solicitação no momento do pedido, a data da resposta na aprovação ou recusa e a data da adoção quando ela for concluída.<br>
RN09 – Animais com status “Adotado” não devem aparecer na lista de disponíveis, e as opções de edição e exclusão não devem ser exibidas para esses casos no painel do usuário.<br>
RN10 – O administrador tem autorização para listar, editar e excluir usuários, animais e adoções.<br>
RN11 – Caso um administrador exclua uma adoção já aprovada, o animal deve retornar automaticamente ao status “Disponível”.<br>
RN12 - Toda adoção deve estar vinculada a um animal existente e a usuários válidos (adotante e doador).<br>
RN13 – Ações críticas como aprovar, recusar e excluir devem exigir confirmação do usuário, e o acesso a áreas restritas deve ser bloqueado por verificação de sessão e nível de acesso.<br>
RN14 – O usuário só pode acessar as funcionalidades do sistema após realizar autenticação (login).<br>
RN15 – Após a realização do cadastro, o sistema deve autenticar automaticamente o usuário.<br>
RN16 – O usuário não pode solicitar a adoção de animais cadastrados por ele mesmo.<br>

<h3>Desenvolvimento do Sistema Web (PHP):</h3> 
Durante o desenvolvimento do Sistema de Adoção foi feito um planejamento inicial definindo objetivos e requisitos (usuário padrão x administrador) e as funcionalidades principais como cadastro/login, CRUD de animais, gerenciamento de adoções e administração de usuários.<br>
A implementação das linguagens e tecnologias seguiu com HTML, CSS e JavaScript para o frontend, PHP com a lógica do backend e MySQL para o Banco de Dados, rodando em XAMPP, e interface com Bootstrap, usando prepared statements e sessões para controle de acesso.<br>
O banco de dados do sistema AUcolher é composto pelas tabelas usuarios, animais e adocao, responsáveis por armazenar os dados dos usuários, dos animais cadastrados e das solicitações de adoção. Cada animal é vinculado a um usuário responsável e cada adoção relaciona um adotante, um doador e um animal. Os relacionamentos garantem a integridade dos dados e o correto funcionamento do processo de adoção.<br>
Cada funcionalidade foi implementada e testada localmente (fluxos de cadastro, login, criar/editar/excluir registros e processo de adoção), tratando casos de borda como e-mails duplicados e campos obrigatórios; as mensagens de feedback ao usuário foram incluídas para sucesso/erro. Foram aplicadas medidas básicas de segurança (prepared statements, verificação de sessão e níveis), mas ainda há muito a ser melhorado nesse quesito.<br>
O sistema está organizado em uma estrutura modular com pastas separadas por funcionalidade. Na raiz ficam apenas index.php e config.php. A pasta public contém o cadastro de usuários. A pasta user gerencia todas as funcionalidades do usuário comum (painel, CRUD de animais, solicitações de adoção e perfil). A pasta admin concentra o gerenciamento administrativo completo (usuários, animais e adoções). A pasta auth trata login e logout. A pasta actions processa as operações de dados (salvar e excluir). A pasta css contém quatro arquivos de estilos separados, e a pasta assets armazena imagens do sistema e uploads de fotos dos animais.<br>
O projeto foi desenvolvido com commits frequentes para facilitar revisões.<br>

<h3>Conclusão </h3> 
Durante o desenvolvimento do sistema AUcolher, surgiram vários desafios, principalmente relacionados aos comandos SQL, relação entre as tabelas do banco, validação de dados e organização das permissões entre usuários e administradores. Entre as principais dificuldades estavam o uso excessivo dos comandos comandos SQL, sobretudo o INNER JOIN, no qual, não trabalhamos muito em aula mas seria essencial para o projeto. Também, um dos desafios foi a necessidade de realizar muitos testes manuais.<br>
Apesar dessas dificuldades, o desenvolvimento trouxe aprendizados muito importantes. Foi possível compreender melhor a importância de se estudar a parte do banco de dados, também, durante o desenvolvimento do projeto, foi notório a importância de utilizar prepared statements para evitar injeção de SQL. Buscamos desenvolver de forma mais organizada, com commits frequentes para facilitar correções e revisões. Além disso, a criação do projeto nos fez perceber o quão importante é estar sempre em busca de mais conhecimentos para serem aplicados em um bom projeto.<br>
Como melhorias futuras, pensamos em fazer um filtro para a busca de animais (buscar por mais próximos, por exemplo) um chat para que os adotantes e doadores tenham uma melhor comunicação e entendimento entre si, opção de cancelar adoção se a mesma ainda estiver pendente.. Também é importante reforçar que para uma adoção responsável, seria necessário uma burocracia muito maior. Essas melhorias tornarão o sistema mais seguro, dinâmico e fiel.<br>
Por fim, o AUcolher vai além de um simples sistema, pois possui um impacto social importante ao ajudar animais a encontrarem um novo lar. O projeto mostrou, na prática, como a tecnologia pode ser usada para ajudar a sociedade, unindo aprendizado técnico com responsabilidade social.<br>
