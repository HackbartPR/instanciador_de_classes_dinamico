## Instanciador de Classes Dinâmico - PHP

No intuito de aprender sobre Reflection API do PHP, esse mini projeto conta com uma Trait chamada 'Sanitizer' que transforma uma lista de valores obtidos do banco de dados em instâncias de classes específicas, preenchendo automaticamente as propriedades correspondentes com os valores adequados.

Ao possuir classes onde um ou mais dos seus atributos são instâncias de outra classe, torna-se necessário realizar uma 'sanitização' dos dados retornados do banco, onde os mesmos, se configurados, retornam como um array associativo. A partir deste array, começasse o processo de criar as instâncias das classes os quais eles fazem parte.


O código utiliza reflexão (Reflection API) e recursão para instanciar objetos de outras classes, garantindo uma conversão precisa e eficiente. É uma solução útil para mapear dados do banco de dados em objetos de domínio em aplicativos PHP.

### Como Testar

Primeiro passo: executar o script do composer (apesar de não haver dependências, o script de autoload precisa ser criado).
~~~php
// Pasta raiz do projeto
composer install
~~~

Segundo passo: executar o script migration.php
~~~php
// Pasta raiz do projeto
php migration.php
~~~

Terceiro passo : executar o script index.php
~~~php
// Pasta raiz do projeto
php index.php
~~~

### Arquivo Sanitizador
O arquivo que contém o código fonte do sanitizador se encontra na pasta: src/Traits/Sanitizer.php
