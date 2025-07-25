<?php

// Conexão com base de dados
$con = mysqli_connect('127.0.0.1', 'root', '', 'recipe_app_dump');
 
if ($con){
    echo "Ligação à base de dados efetuada com sucesso!\n";
} else {
    echo "Erro a conectar com a base de dados\n";
}

//Menu inicial 
$sair = false;
while(!$sair){
        echo "\n---------------------------------------------------------\n";
        echo "\t -ESCOLHA UMA OPÇÃO-";
        echo "\n---------------------------------------------------------\n";
        echo "[1]\t\t -\t\t Receitas\n\n";
        echo "[2]\t\t -\t\t Ingredientes\n\n";
        echo "[3]\t\t -\t\t Categorias\n\n";
        echo "[4]\t\t -\t\t Pesquisa de Receitas";
        echo "\n---------------------------------------------------------\n";
        echo "[0]\t\t -\t\t Sair";
        echo "\n---------------------------------------------------------\n";
$menu_inicial = readline("R: ");

switch ($menu_inicial) {
    case 0:
        $sair = true;
        break;
    case 1:
        echo "\n---------------------------------------------------------\n";
        echo "[1]\t\t -\t\t Nova Receita\n\n";
        echo "[2]\t\t -\t\t Lista de Receitas\n\n";
        echo "[3]\t\t -\t\t Atualizar Receita Existente\n\n";
        echo "[4]\t\t -\t\t Apagar Receita";
        echo "\n---------------------------------------------------------\n";
        $input = readline("\nR: ");
        if ($input == "1") {
            addReceita($con);
            break;
        }else if ($input == "2") {
            seeReceitas($con, true);
            break;
        }else if ($input == "3") {
            upReceita($con, true);
            break;
        }else if ($input == "4") {
            delReceita($con, true);
            break;
        }else{
        echo "Erro: Opção Menu Inválida";
        break;
    }
    case 2:
        echo "\n---------------------------------------------------------\n";
        echo "[1]\t\t -\t\t Novo Ingrediente\n\n";
        echo "[2]\t\t -\t\t Lista de Ingredientes\n\n";
        echo "[4]\t\t -\t\t Apagar Ingrediente";
        echo "\n---------------------------------------------------------\n";
        $input = readline("\nR: ");
        if ($input == "1") {
            addIngrediente($con);
            break;
        }else if ($input == "2") {
            seeIngredientes($con, true);
            break;
        }else if ($input == "3") {
            delIngrediente($con, true);
            break;
        }else{
        echo "Erro: Opção Menu Inválida";
        break;
    }
    case 3:
        echo "\n---------------------------------------------------------\n";
        echo "[1]\t\t -\t\t Nova Categoria\n\n";
        echo "[2]\t\t -\t\t Lista de Categorias\n\n";
        echo "[3]\t\t -\t\t Apagar Categoria";
        echo "\n---------------------------------------------------------\n";
        $input = readline("\nR: ");
        if ($input == "1") {
            addCategoria($con);
            break;
        }else if ($input == "2") {
            seeCategorias($con, true);
            break;
        }else if ($input == "3") {
            delCategoria($con, true);
            break;
        }else{
        echo "Erro: Opção Menu Inválida";
        break;
    }
    case 4:
        echo "\n---------------------------------------------------------\n";
        echo "[1]\t\t -\t\t Por Categoria\n\n";
        echo "[2]\t\t -\t\t Por Ingrediente\n\n";
        echo "[3]\t\t -\t\t Por Titulo";
        echo "\n---------------------------------------------------------\n";
        $input = readline("\nR: ");
        if ($input == "1") {
            procurarCategoria($con, true);
            break;
        }else if ($input == "2") {
            procurarIngrediente($con, true);
            break;
        }else if ($input == "3") {
            procurarTitulo($con, true);
            break;
        }else{
        echo "Erro: Opção Menu Inválida";
        break;
    }
    default:
        echo "Erro: Opção Menu Inválida";
        break;
        }
}

//opção voltar ao menu

function Voltar(){
    $input = "";
    echo "\n---------------------------------------------------------\n";
    echo "[0]\t\t -\t\tVoltar\n";
    echo "---------------------------------------------------------\n";
    $input = readline("\nR: ");
    while ($input != "0") {
        $input = readline("");
    }
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////  Operações CRUD  ////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

///////////////////
// CRUD - CREATE //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//Adicionar nova receita

function addReceita($con){
    //adicionar variaveis da tabela Receita
    $nome = readline("Titulo: ");
    $prep = readline("Tempo de Preparação [HH:mm:ss]: ");
    $dose = readline("Dose Esperada: ");

    //Categorias em string
    seeCategorias($con, false);
    echo "\n---------------------------------------------------------\n";
    $categorias_string = readline("Categorias (separado por vígulas): ");
    $categorias = explode(",", $categorias_string);

    $sql = "INSERT INTO receitas (nome, prep, dose) VALUES ('$nome', '$prep', $dose)";
    $id_receita = mysqli_insert_id($con);

        foreach ($categorias as $id_categoria){
                if ($id_categoria > 0){
                $sql_assoc = "INSERT INTO receita_categoria (id_receita, id_categoria) VALUES ($id_receita, '$id_categoria')";
                    if (mysqli_query($con, $sql_assoc)){
                        echo "Sucesso: Associação receita_categoria\n";
                            } else {
                            echo "Erro: Associação receita_categoria\n";
                        }
                    }
                }

    //Ingredientes e Quantidades
    $sair = false;
    while(!$sair){
        seeIngredientes($con, false);
        echo "\n---------------------------------------------------------\n";
        echo "[1]\t\t -\t\t Adicionar Ingrediente\n";
        echo "[0]\t\t -\t\t Continuar\n";
        echo "\n---------------------------------------------------------\n";
        $input = readline("R: ");
            switch ($input) {
                case 0:
                    $sair = true;
                    break;
                case 1:
                    $id_receita = mysqli_insert_id($con);
                    $id_ingrediente = readline("Ingrediente: ");
                    $quantidade = readline("Quantidade: ");
                    $sql_assoc = "INSERT INTO receita_ingrediente (id_ingrediente, quantidade) VALUES ('$id_ingrediente', '$quantidade') WHERE id_receita = $id_receita";
                        if (mysqli_query($con, $sql_assoc)){
                            echo "\nSucesso: Associação receita_ingrediente\n";
                        } else {
                            echo "\nErro: Associação receita_ingrediente\n";}
                    break;
                default:
                    echo "\nErro: Opção Menu Inválida\n";
                    break;
            }                 
        }
    
    $descricao = readline("Receita: ");
    $sql = "INSERT INTO receitas (descricao) VALUES ('$descricao') WHERE id_receita = $id_receita";

    //Verificações
    if (mysqli_query($con, $sql)){
        echo "\nSucesso: Inserir Receita\n";
    } else {
        echo "\nErro: Inserir Receita\n";
    }
}

//Adicionar nova categoria
function addCategoria($con){
    $id = readline("Nome da Categoria: ");
    $descricao = readline("Insira uma pequena descrição sobre a Categoria:\n");
    $sql = "INSERT INTO categorias (id_categoria, descricao) VALUES ('$id','$descricao')";

 //Verificações
    if (mysqli_query($con, $sql)){
        echo "\nSucesso: Inserir Categoria\n";
    } else {
        echo "\nErro: Inserir Categoria\n";
    }
}
//Adicionar novo Ingrediente
function addIngrediente($con){
    $id = readline("Ingrediente: ");
    $sql = "INSERT INTO ingredientes (id_ingrediente) VALUES ('$id')";

 //Verificações
    if (mysqli_query($con, $sql)){
        echo "\nSucesso: Inserir Ingrediente\n";
    } else {
        echo "\nErro: Inserir Ingrediente\n";
    }
}

///////////////////
//  CRUD - READ  //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//lista de todas a receitas / + Categorias
function seeReceitas($con, $voltar){
    $sql = "SELECT receitas.id_receita,
        receitas.nome,
        receitas.descricao,
        receitas.prep,
        receitas.dose, 
        receita_ingrediente.id_ingrediente, 
        receita_ingrediente.quantidade,
        receita_categoria.id_categoria
        FROM receitas
        INNER JOIN receita_ingrediente ON receitas.id_receita = receita_ingrediente.id_receita 
        INNER JOIN receita_categoria ON receitas.id_receita = receita_categoria.id_receita
        ORDER BY receitas.id_receita";
        $resultado = mysqli_query($con, $sql);
   
    $receita_atual = NULL;
    $categoria = [];
    $ingrediente = [];
    $quantidade = [];

    while ($linha = mysqli_fetch_assoc($resultado)){
        $id = $linha["id_receita"];
    
        if($id != $receita_atual){
            if($receita_atual != NULL){
            echo "\t\nCategorias:\n";
            echo "\t-" .  implode(" ", $categoria) . "\n";
            echo "\t\nIngredientes:\n";
            echo "\t-" .  implode(" ",  $quantidade) . "  " . implode(" ", $ingrediente) . "\n";
            }
            echo "\n---------------------------------------------------------\n";
            echo "\t\nID: " . $linha["id_receita"];
            echo "\t\nTitulo: " . $linha["nome"];
            echo "\t\nTempo de Preparação [HH:mm:ss]:  " . $linha["prep"];
            echo "\t\nDose Esperada: " . $linha["dose"];
            echo "\t\nReceita: ";
            echo "\n" . $linha["descricao"];
            echo "\n---------------------------------------------------------\n";
            $receita_atual = $id;
            $categoria = [];
            $ingrediente = [];
            $quantidade = [];
        }
        $categoria[] = $linha["id_categoria"];
        $ingrediente [] = $linha["id_ingrediente"];
        $quantidade [] = $linha["quantidade"];
            
    }if ($receita_atual != NULL){
        echo "\t\nCategorias:\n";
        echo "\t-" .  implode(" ", $categoria) . "\n";
        echo "\t\nIngredientes:\n";
        echo "\t-" .  implode(" ",  $quantidade) . "  " . implode(" ", $ingrediente) . "\n";
    }
         
    if ($voltar){
    Voltar();
    }
}

//lista de todos os Ingredientes
function seeIngredientes($con, $voltar){
    $sql = "SELECT id_ingrediente FROM ingredientes";
    $resultado = mysqli_query($con, $sql);
    echo "\n---------------------------------------------------------\n";
    echo "\tTodos os Ingredientes Disponiveis";
    echo "\n---------------------------------------------------------\n";
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "\n\t - " . $linha["id_ingrediente"];
    }if ($voltar){
        Voltar();
    }
}

//lista de todas as Categorias
function seeCategorias($con, $voltar){
    $sql = "SELECT id_categoria, descricao FROM categorias";
    $resultado = mysqli_query($con, $sql);
    echo "\n---------------------------------------------------------\n";
    echo "\tTodas as Categorias Disponiveis";
    echo "\n---------------------------------------------------------\n";
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "\n---------------------------------------------------------\n";
        echo "\t\nCategoria: " . $linha["id_categoria"];
        echo "\t\nDescrição: ";
        echo "\t\n - " . $linha["descricao"];
    }if ($voltar){
        Voltar();
    }
}

///////////////////
// CRUD - UPDATE //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//atualizar receita existente // + Associar e Desassociar categorias
function upReceita($con, $voltar){
    seeReceitas($con,false);
        $id = readline("ID da Receita: ");
        $sql = "SELECT receitas.id_receita,
        receitas.nome,
        receitas.descricao,
        receitas.prep,
        receitas.dose, 
        receita_ingrediente.id_ingrediente, 
        receita_ingrediente.quantidade,
        receita_categoria.id_categoria
        FROM receitas WHERE id_receita = $id
        INNER JOIN receita_ingrediente ON receitas.id_receita = receita_ingrediente.id_receita 
        INNER JOIN receita_categoria ON receitas.id_receita = receita_categoria.id_receita
        GROUP BY receitas.id_receita";
        $resultado = mysqli_query($con, $sql);
        if (mysqli_num_rows($resultado) == 0){
            echo "Erro: Receita Não Encontrada";
            return;
        }
        while (mysqli_fetch_assoc($resultado)){
        echo "\n---------------------------------------------------------\n";
        echo "\n[1] Titulo";
        echo "\n[2] Tempo de Preparação";
        echo "\n[3] Dose Esperada";
        echo "\t[4] Ingredientes";
        echo "\n[5] Categoria";
        echo "\n[6] Receita";
        echo "\n---------------------------------------------------------\n";
         $edit = readline("Que secção deseja editar? ");

        Switch ($edit){
            case 1:
                $novoNome = readline("Mudar Titulo: ");
                $sql = "UPDATE receitas SET nome = '$novoNome' WHERE id_receita = $id";
                break;
            case 2:
                $novoPrep = readline("Mudar Tempo de Preparação: ");
                $sql = "UPDATE receitas SET prep = '$novoPrep' WHERE id_receita = $id";
                break;
            case 3:
                $novaDose = readline("Mudar Dose Esperada: ");
                $sql = "UPDATE receitas SET dose = '$novaDose' WHERE id_receita = $id";
                break;
            case 4: //Associar e Desassociar Ingredientes/quantidades
                seeIngredientes($con,false);
                echo "[1] - Nova Categoria";
                echo "[2] - Eliminar Categoria";
                $input = readline("");
                    if($input =="1"){
                        $novoIngrediente = readline("Novo Ingrediente: ");
                        $sql = "UPDATE receita_ingrediente ADD id_ingrediente = '$novoIngrediente' WHERE id_receita = $id";
                        $novaQuantidade = readline("Nova Quantidade: ");
                        $sql = "UPDATE receita_ingrediente ADD quantidade = '$novaQuantidade' WHERE id_receita = $id";
                    }else if ($input == "2"){
                        $delete = readline("ID do Ingrediente que deseja remover: ");
                        $sql = "DELETE id_ingrediente, quantidade WHERE id_ingrediente = $delete
                        FROM receita_ingrediente WHERE id_receita = $id";
                    }else{
                        echo "Erro: Opção Menu Inválida";
                    }
                break;
            case 5: //Associar e Desassociar Categorias
                seeCategorias($con,false);
                echo "[1] - Nova Categoria";
                echo "[2] - Eliminar Categoria";
                $input = readline("");
                    if ($input == "1"){
                        $novaCategoria = readline("Nova Categoria: ");
                        $sql = "UPDATE receita_categoria ADD id_categoria = '$novaCategoria' WHERE id_receita = $id";
                    }else if ($input == "2"){
                        $delete = readline("ID da Categoria que deseja remover: ");
                        $sql = "DELETE id_categoria WHERE id_categoria = $delete
                        FROM receita_categoria WHERE id_receita = $id";
                    }else{
                        echo "Erro: Opção Menu Inválida";
                    }
                break;
            case 6:
                $novaDescricao = readline("Mudar Receita: ");
                $sql = "UPDATE receitas SET descricao = '$novaDescricao' WHERE id_receita = $id";
                break;
            default:
                echo "Erro: Opção Menu Inválida";
                break;
            }  

        mysqli_query($con, $sql);
        echo "Successo: Receita Atualizada.";
        } if ($voltar){
        Voltar();
        } 
}



///////////////////
// CRUD - DELETE //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//apagar receita 
function delReceita($con){
    seeReceitas($con, false);
    $id = readline("ID da Receita que deseja remover: ");
    $sql = "SELECT id_receita FROM receitas WHERE id_receita = $id";
    $verificacao = mysqli_query($con, $sql);
    if (mysqli_num_rows ($verificacao) == 0){
        echo ("Erro: Receita não encontrada");
        return;
    }
    //apagar associações
    $sql = "DELETE FROM receita_categoria WHERE id_receita = $id";
    mysqli_query($con, $sql);
    $sql = "DELETE FROM receita_ingrediente WHERE id_receita = $id";
    mysqli_query($con, $sql);
    $sql = "DELETE FROM receitas WHERE id_receita= $id";
    mysqli_query($con, $sql);
    echo "Sucesso: Receita Removida";
}

//apagar categoria
function delCategoria($con){
    seeCategorias($con, false);
    $id = readline("ID da Categoria que deseja remover: ");
    $sql = "SELECT id_categoria FROM categorias WHERE id_categoria = $id";
    $verificacao = mysqli_query($con, $sql);
    if (mysqli_num_rows ($verificacao) == 0){
        echo ("Erro: Categoria não encontrada");
        return;
    }
    //apagar associações
    $sql = "DELETE FROM receita_categoria WHERE id_categoria = $id";
    mysqli_query($con, $sql);
    $sql = "DELETE FROM categorias WHERE id_categoria= $id";
    mysqli_query($con, $sql);
    echo "Sucesso: Categoria Removida";
}

//apagar ingredientes
function delIngrediente($con){
    seeIngredientes($con, false);
    $id = readline("ID da Ingrediente que deseja remover: ");
    $sql = "SELECT id_ingrediente FROM ingredientes WHERE id_ingrediente = $id";
    $verificacao = mysqli_query($con, $sql);
    if (mysqli_num_rows ($verificacao) == 0){
        echo ("Erro: Ingrediente não encontrado");
        return;
    }
    //apagar associações
    $sql = "DELETE FROM receita_ingrediente WHERE id_ingrediente = $id";
    mysqli_query($con, $sql);
    $sql = "DELETE FROM ingredientes WHERE id_ingrediente= $id";
    mysqli_query($con, $sql);
    echo "Sucesso: Ingrediente Removido";
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////  Funcionalidades de Pesquisa  ///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//procurar receitas por categoria
function procurarCategoria($con, $voltar){
    $categoria = readline("Categoria: ");
        $sql = "SELECT receitas.id_receita,
        receitas.nome,
        receitas.descricao,
        receitas.prep,
        receitas.dose, 
        receita_ingrediente.id_ingrediente, 
        receita_ingrediente.quantidade,
        receita_categoria.id_categoria
        FROM receitas
        INNER JOIN receita_ingrediente ON receitas.id_receita = receita_ingrediente.id_receita 
        INNER JOIN receita_categoria ON receitas.id_receita = receita_categoria.id_receita
        GROUP BY receitas.id_receita WHERE receita_categoria.id_categoria LIKE '%$categoria%'";

    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado) == 0){
            echo "Erro: Receita Não Encontrada";
            return;
    }
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "---------------------------------------------------------\n";
        echo "\n[Titulo:  " . $linha["nome"];
        echo "\nTempo de Preparação:  " . $linha["prep"];
        echo "\nDose Esperada:  " . $linha["dose"];
        echo "\tIngredientes:  " . "\t-"  . implode("quantidade") . " ". implode("id_ingrediente"). "\n";
        echo "\nCategorias:  " . "\t-"  . implode("id_categoria"). "\n";
        echo "\nReceita: ";
        echo "\n ". $linha["descricao"];
        echo "\n---------------------------------------------------------\n";
    }
    mysqli_query($con, $sql);
    echo "\n\nSuccesso: Receita Encontrada\n";

    if ($voltar){
        voltar();
    }
}

//procurar receitas por Ingrediente
function procurarIngrediente($con, $voltar){
    $ingrediente = readline("Ingrediente: ");
       $sql = "SELECT receitas.id_receita,
        receitas.nome,
        receitas.descricao,
        receitas.prep,
        receitas.dose, 
        receita_ingrediente.id_ingrediente, 
        receita_ingrediente.quantidade,
        receita_categoria.id_categoria
        FROM receitas
        INNER JOIN receita_ingrediente ON receitas.id_receita = receita_ingrediente.id_receita 
        INNER JOIN receita_categoria ON receitas.id_receita = receita_categoria.id_receita
        GROUP BY receitas.id_receita WHERE receita_ingrediente.id_ingrediente LIKE '%$ingrediente%'";

    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado) == 0){
            echo "Erro: Receita Não Encontrada";
            return;
    }
        while ($linha = mysqli_fetch_assoc($resultado)){
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "---------------------------------------------------------\n";
        echo "\n[1] Titulo:  " . $linha["nome"];
        echo "\n[2] Tempo de Preparação:  " . $linha["prep"];
        echo "\n[3] Dose Esperada:  " . $linha["dose"];
        echo "\t[4] Ingredientes:  " . "\t-"  . implode("quantidade") . " ". implode("id_ingrediente"). "\n";
        echo "\n[5] Categorias:  " . "\t-"  . implode("id_categoria"). "\n";
        echo "\nReceita: ";
        echo "\n ". $linha["descricao"];
        echo "\n---------------------------------------------------------\n";
    }
    mysqli_query($con, $sql);
    echo "\n\nSuccesso: Receita Encontrada\n";

        if ($voltar){
            voltar();
        }
    }
}

//procurar receitas por Titulo
function procurarTitulo($con, $voltar){
    $nome = readline("Titulo da Receita: ");
       $sql = "SELECT receitas.id_receita,
        receitas.nome,
        receitas.descricao,
        receitas.prep,
        receitas.dose, 
        receita_ingrediente.id_ingrediente, 
        receita_ingrediente.quantidade,
        receita_categoria.id_categoria
        FROM receitas
        INNER JOIN receita_ingrediente ON receitas.id_receita = receita_ingrediente.id_receita 
        INNER JOIN receita_categoria ON receitas.id_receita = receita_categoria.id_receita
        GROUP BY receitas.id_receita WHERE receitas.nome LIKE '%$nome%'";

    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado) == 0){
            echo "Erro: Receita Não Encontrada";
            return;
    }
        while ($linha = mysqli_fetch_assoc($resultado)){
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "---------------------------------------------------------\n";
        echo "\n[1] Titulo:  " . $linha["nome"];
        echo "\n[2] Tempo de Preparação:  " . $linha["prep"];
        echo "\n[3] Dose Esperada:  " . $linha["dose"];
        echo "\t[4] Ingredientes:  " . "\t-"  . implode("quantidade") . " ". implode("id_ingrediente") . "\n";
        echo "\n[5] Categorias:  " . "\t-"  . implode("id_categoria"). "\n";
        echo "\nReceita: ";
        echo "\n ". $linha["descricao"];
        echo "\n---------------------------------------------------------\n";
    }
    mysqli_query($con, $sql);
    echo "\n\nSuccesso: Receita Encontrada\n";

        if ($voltar){
            voltar();
        }
    }
}

//encerrar a conexão
$bye = mysqli_close($con);
if ($bye){
    echo "\nPrograma Terminado!\n";
} else {
    echo "\nErro a encerrar conexão com a base de dados\n";
}