<h1 align="center">Projeto AUcolher</h1>
<p align="center">Sistema de Adoção de Animais</p>
<p align="center">
  <img align="center" width="100" height="99" alt="logorealista" src="https://github.com/user-attachments/assets/a4826fe1-d8be-41ee-b310-9cb34ca496c8" />
</p>
<br>

O Projeto Aucolher tem como objetivo facilitar a adoção responsável de animais, conectando adotantes a doadores. Ele resolve a dificuldade no processo de adoção, oferecendo uma plataforma simples e acessível, promovendo a conscientização e contribuindo para a redução do abandono.
<br><br>

<h3>-Diagrama de Caso de Uso</h3>
<p align="center">
<img width="500" height="900" alt="DiagramaCasoslide drawio" src="https://github.com/user-attachments/assets/1eebb8f6-a14d-4e77-8943-972f75cde8ff" />
<p/>
<br><br>

<h3>-Diagrama de Classe</h3>
<p align="center">
<img width="1066" height="584" alt="DiagramaDeClasseslideee-SistemaAdoção-Página-1 drawio" src="https://github.com/user-attachments/assets/7a2f8df4-0f07-48e7-b432-7bec5abebf79" />
<p/>
<br><br>

<h3>-Diagrama de Entidade e Relacionamento</h3>
<p align="center">
<img width="970" height="481" alt="Captura de tela 2025-12-04 214223" src="https://github.com/user-attachments/assets/d91e54a6-3721-4888-971d-18a4359fa90a" />
<p/>
<br><br>

<h3>-Requisitos Funcionais (RF)</h3>
RF01: Permitir a criação de contas com nome, e-mail, senha e definição do nível de acesso.<br>
RF02: Possibilitar o login no sistema, gerar a sessão do usuário e restringir acessos conforme o perfil (usuário ou administrador).<br>
RF03: Permitir o cadastro de pets contendo nome, espécie, raça, idade, sexo, descrição, imagem e situação atual.<br>
RF04: Apresentar tanto os animais cadastrados pelo próprio usuário quanto os animais disponíveis de outros usuários.<br>
RF05: Possibilitar a manutenção e alteração do status entre “Disponível” e “Adotado”.<br>
RF06: Permitir que o usuário realize a solicitação de adoção de um animal.<br>
RF07: Impedir que um mesmo usuário faça mais de uma solicitação para o mesmo animal enquanto houver uma pendente.<br>
RF08: Permitir que o doador aprove ou recuse as solicitações recebidas.<br>
RF09: Ao aprovar uma solicitação, o sistema deve definir o animal como “Adotado” e cancelar automaticamente as demais solicitações pendentes.<br>
RF10: Armazenar as datas de solicitação, resposta e da adoção realizada.<br>
RF11: Permitir ao usuário acompanhar a situação de seus pedidos (pendente, aprovada ou recusada).<br>
RF12: Possibilitar ao doador visualizar e administrar as solicitações referentes aos seus animais.<br>
RF13: Permitir que o proprietário edite as informações do animal enquanto ele estiver disponível.<br>
RF14: Permitir que o dono ou o administrador exclua animais, mediante confirmação da ação.<br>
RF15: Possibilitar ao administrador listar, atualizar e remover usuários do sistema.<br>
RF16: Permitir ao administrador visualizar, editar e excluir quaisquer animais cadastrados.<br>
RF17: Possibilitar ao administrador listar, alterar status/datas e excluir registros de adoção.<br>
RF18: Impedir o cadastro de contas com e-mail já existente no sistema.<br>
RF19: Exibir apenas animais com status “Disponível” na área pública de adoção.<br>
RF20: Disponibilizar navegação por âncoras para “Meus Animais”, “Solicitações Recebidas”, “Animais Disponíveis” e “Minhas Solicitações”.<br>
RF21: Permitir o upload e a exibição de fotos dos animais cadastrados.<br>
RF22: Permitir que o usuário finalize sua sessão por meio da função de logout com confirmação.<br><br>






<h3>-Requisitos Não Funcionais (RNF)</h3> 
RNF01: O sistema deve registrar logs básicos de ações importantes (login, cadastro, adoção, exclusão) para fins de controle e verificação.<br>
RNF02: O sistema deve garantir segurança nas sessões, validação dos dados informados e controle de permissões por tipo de usuário.<br>
RNF03: Os dados de status entre as tabelas de animais e adoções devem permanecer sempre sincronizados durante aprovações e recusas.<br>
RNF04: A interface deve ser adaptável a diferentes telas, com navegação simples e mensagens claras de erro e sucesso.<br>
RNF05: O código deve ser bem estruturado, com funções organizadas e nomes claros para variáveis e campos.<br>
RNF06: O sistema deve suportar vários pedidos de adoção para um mesmo animal, resolvendo conflitos automaticamente.<br>
RNF07: O sistema deve operar corretamente em PHP 7.4 ou superior, utilizando MySQLi e Bootstrap 5.3.2.<br>
RNF08: A interface deve possuir bom contraste de cores, textos legíveis e ícones acompanhados de rótulos explicativos.<br>
RNF09: O sistema deve evitar a exibição de informações desatualizadas por meio do controle de cache no painel.<br>
RNF10: O sistema deve funcionar corretamente em ambientes locais como XAMPP e similares.<br>
RNF11: Todas as páginas devem manter o mesmo estilo de cores, fontes e animações leves.<br><br>  


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
RN16 – O usuário não pode solicitar a adoção de animais cadastrados por ele mesmo.<br><br>

<h3>Desenvolvimento do Sistema Web (PHP):</h3> 
Durante o desenvolvimento do Sistema de Adoção foi feito um planejamento inicial definindo objetivos e requisitos (usuário padrão x administrador) e as funcionalidades principais como cadastro/login, CRUD de animais, gerenciamento de adoções e administração de usuários.<br>
A implementação das linguagens e tecnologias seguiu com HTML, CSS e JavaScript para o frontend, PHP com a lógica do backend e MySQL para o Banco de Dados, rodando em XAMPP, e interface com Bootstrap, usando prepared statements e sessões para controle de acesso.<br>
O banco de dados do sistema AUcolher é composto pelas tabelas usuarios, animais e adocao, responsáveis por armazenar os dados dos usuários, dos animais cadastrados e das solicitações de adoção. Cada animal é vinculado a um usuário responsável e cada adoção relaciona um adotante, um doador e um animal. Os relacionamentos garantem a integridade dos dados e o correto funcionamento do processo de adoção.<br>
Cada funcionalidade foi implementada e testada localmente (fluxos de cadastro, login, criar/editar/excluir registros e processo de adoção), tratando casos de borda como e-mails duplicados e campos obrigatórios; as mensagens de feedback ao usuário foram incluídas para sucesso/erro. Foram aplicadas medidas básicas de segurança (prepared statements, verificação de sessão e níveis), mas ainda há muito a ser melhorado nesse quesito.<br>
O sistema está organizado em uma estrutura modular com pastas separadas por funcionalidade. Na raiz ficam apenas index.php e config.php. A pasta public contém o cadastro de usuários. A pasta user gerencia todas as funcionalidades do usuário comum (painel, CRUD de animais, solicitações de adoção e perfil). A pasta admin concentra o gerenciamento administrativo completo (usuários, animais e adoções). A pasta auth trata login e logout. A pasta actions processa as operações de dados (salvar e excluir). A pasta css contém quatro arquivos de estilos separados, e a pasta assets armazena imagens do sistema e uploads de fotos dos animais.<br>
O projeto foi desenvolvido com commits frequentes para facilitar revisões.<br><br>

<h3>Testes e Validação</h3>
Após a conclusão do desenvolvimento do sistema, foram feitos alguns testes para confirmar se realmente condiz com os requisitos citados acima.<br>
Testes realizados: login, cadastro e login automático após o cadastro, excluir animais cadastrados (usuário), editar perfil (usuário), cadastrar animal para adoção, editar animais cadastrados (usuário), recusar automaticamente todas as solicitações de outros usuários após aceitar a solicitação de um usuário, acompanhar o status da solicitação de adoção (pendente, aprovado ou recusado), gerenciamento completo de usuários, animais e adoções (editar e excluir) (administrador), cadastrar usuário com nível administrador.<br>

Contudo, notamos total coerência com os requisitos necessários para a execução sincera do sistema. O mesmo está funcionando perfeitamente.<br><br>

<h3>Conclusão </h3> 
Durante o desenvolvimento do sistema AUcolher, surgiram vários desafios, principalmente relacionados aos comandos SQL, relação entre as tabelas do banco, validação de dados e organização das permissões entre usuários e administradores. Entre as principais dificuldades estavam o uso excessivo dos comandos comandos SQL, sobretudo o INNER JOIN, no qual, não trabalhamos muito em aula mas seria essencial para o projeto. Também, um dos desafios foi a necessidade de realizar muitos testes manuais.<br>
Apesar dessas dificuldades, o desenvolvimento trouxe aprendizados muito importantes. Foi possível compreender melhor a importância de se estudar a parte do banco de dados, também, durante o desenvolvimento do projeto, foi notório a importância de utilizar prepared statements para evitar injeção de SQL. Buscamos desenvolver de forma mais organizada, com commits frequentes para facilitar correções e revisões. Além disso, a criação do projeto nos fez perceber o quão importante é estar sempre em busca de mais conhecimentos para serem aplicados em um bom projeto.<br>
Como melhorias futuras, pensamos em fazer um filtro para a busca de animais (buscar por mais próximos, por exemplo) um chat para que os adotantes e doadores tenham uma melhor comunicação e entendimento entre si, opção de cancelar adoção se a mesma ainda estiver pendente.. Também é importante reforçar que para uma adoção responsável, seria necessário uma burocracia muito maior. Essas melhorias tornarão o sistema mais seguro, dinâmico e fiel.<br>
Por fim, o AUcolher vai além de um simples sistema, pois possui um impacto social importante ao ajudar animais a encontrarem um novo lar. O projeto mostrou, na prática, como a tecnologia pode ser usada para ajudar a sociedade, unindo aprendizado técnico com responsabilidade social.<br><br>

