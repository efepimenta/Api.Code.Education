## Agora é a vez do doctrine...  

rodar o fixture antes  

A paginacao esta na busca por produtos via busca avancada.  

estou melhorando o paginador (vi que o doctrine tem um mas nao usei), ja que podem ser vistos bugs.  

em breve ajustarei a parte visual, ja que tambem existem bugs.  

devo estar criando um sistema de bugs...  

A categoria informada via api deve ser inteiro, nao string  

##-- NOVAS INFORMAÇÔES --

A dependencia do PDO foi removida, tornando o projeto inteiramente doctrine  

O produto agora necessita das tags. Pela api, elas devem ser separadas por ;  
Se a tag nao existir, ela será criada..