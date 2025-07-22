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
        echo "[3]\t\t -\t\t Categorias";
        echo "\n---------------------------------------------------------\n";
        echo "[0]\t\t -\t\t Sair";
        echo "\n---------------------------------------------------------\n";
$menu_inicial = readline("R: ");

switch ($menu_inicial) {
    case 0:
        $sair = true;
        break;
    case 1:
        $input = "";
        echo "---------------------------------------------------------\n";
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
            seeReceita($con, true);
            break;
        }else if ($input == "3") {
            upReceita($con, true);
            break;
        }else if ($input == "3") {
            delReceita($con, true);
            break;
        }else{
        echo "Erro: Opção Menu Inválida";
        break;
    }
    case 2:
        echo "Vazio";
        break;
    case 3:
        echo "Vazio";
        break;
    case 4:
        echo "Vazio";
        break;
    default:
        echo "Erro: Opção Menu Inválida";
        break;
        }
}

//opção voltar ao menu

function Voltar(){
    $input = "";
    echo "---------------------------------------------------------\n";
    echo "[0]\t\t -\t\tVoltar\n";
    echo "---------------------------------------------------------\n";
    $input = readline("\nR: ");
    while ($input != "0") {
        $input = readline("");
    }
}



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////  Fase 4 - Operações CRUD basicas de Receita  //////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


////////////////////////
// Funções Auxiliares //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


///////////////////
// CRUD - CREATE //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//Adicionar nova receita  (INCOMPLETO)

function addReceita($con){
    $id_receita = mysqli_insert_id($con);

    //adicionar variaveis da tabela Receita
    $nome = readline("Titulo: ");
    $prep = readline("Tempo de Preparação [HH:mm:ss]: ");
    $dose = readline("Dose Esperada: ");
    
    //Categorias em string
    seeCategorias($con, false);
    echo "\n---------------------------------------------------------\n";
    $categorias_string = readline("\nCategorias (separado por vígulas): ");
    $categorias = explode(",", $categorias_string);
    foreach ($categorias as $id_categoria){
            if ($id_categoria > 0){
            $sql_assoc = "INSERT INTO receita_categoria (id_receita, id_categoria) VALUES ('$id_receita', '$id_categoria')";
                if (mysqli_query($con, $sql_assoc)){
                    echo "Sucesso: Associação receita_categoria\n";
                        } else {
                        echo "Erro: Associação receita_categoria\n";
                    }
                }
            }

    //Ingredientes e Quantidades em string
    $sair = false;
    while(!$sair){
        seeIngredientes($con, false);
        echo "\n---------------------------------------------------------\n";
        echo "[1]\t\t -\t\t Adicionar Ingrediente\n";
        echo "[0]\t\t -\t\t Continuar\n";
        echo "---------------------------------------------------------\n";
        $input = readline("R: ");

            switch ($input) {
                case 0:
                    $sair = true;
                    break;
                case 1:
                    $id_ingrediente = readline("\nIngrediente: ");
                    $quantidade = readline("Quantidade: ");
                    $sql_assoc = "INSERT INTO receita_ingrediente (id_ingrediente, quantidade) VALUES ($id_ingrediente, $quantidade) WHERE id_receita = $id_receita";
                        if (mysqli_query($con, $sql_assoc)){
                            echo "Sucesso: Associação receita_ingrediente\n";
                        } else {
                            echo "Erro: Associação receita_ingrediente\n";}
                default:
                    echo "Erro: Opção Menu Inválida";
                    break;
            }                 
        }
        
    //Corpo da receita (deixei para o fim por razões de interface com o utilizador)
    $descricao = readline("Receita: ");
    $sql = "INSERT INTO receitas (nome, descricao, prep, dose) VALUES ('$nome', '$descricao', '$prep','$dose')";
    
    //Verificações
    if (mysqli_query($con, $sql)){
        echo "Sucesso: Inserir Receita\n";
    } else {
        echo "Erro: Inserir Receita\n";
    }
}

///////////////////
//  CRUD - READ  //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//lista de todas a receitas com Ingredientes e Quantidade
function seeReceita($con, $voltar){
    $sql = "SELECT receitas.id_receita, receitas.nome, receitas.descricao, receitas.prep, receitas.dose, receita_ingrediente.id_ingrediente, receita_ingrediente.quantidade FROM receitas
    INNER JOIN receita_ingrediente
    ON receitas.id_receita = receita_ingrediente.id_receita";
    $resultado = mysqli_query($con, $sql);
    while ($linha = mysqli_fetch_assoc($resultado)){
        echo "---------------------------------------------------------\n";
        echo "\t\nID:  " . $linha["id_receita"];
        echo "\t\nTitulo:  " . $linha["nome"];
        echo "\t\nTempo de Preparação [HH:mm:ss]:  " . $linha["prep"];
        echo "\t\nDose Esperada:  " . $linha["dose"];
        echo "\t\nIngredientes:  " . $linha["id_ingrediente"] . $linha["quantidade"];
        echo "\t\n\nReceita:  " . $linha["descricao"];
        echo "---------------------------------------------------------\n";
    }if ($voltar){
        Voltar();
    }
}

//lista de todos os Ingredientes
function seeIngredientes($con, $voltar){
    $sql = "SELECT id_ingrediente FROM ingredientes";
    $resultado = mysqli_query($con, $sql);
    echo "Todos os Ingredientes Disponiveis\n";
    echo "---------------------------------------------------------\n";
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "\n" . $linha["id_ingrediente"];
    }if ($voltar){
        Voltar();
    }
}

//lista de todas as Categorias
function seeCategorias($con, $voltar){
    $sql = "SELECT id_categoria, descricao FROM categorias";
    $resultado = mysqli_query($con, $sql);
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "---------------------------------------------------------\n";
        echo "\t\nCategoria:  " . $linha["id_categoria"];
        echo "\t\nDescrição:  " . $linha["descricao"];
    }if ($voltar){
        Voltar();
    }
}

///////////////////
// CRUD - UPDATE //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//atualizar receita existente
function upReceita($con, $voltar){
    seeReceita($con,false);
        $id = readline("ID do livro: ");
        $sql = "SELECT receitas.id_receita, receitas.nome, receitas.descricao, receitas.prep, receitas.dose, receita_ingrediente.id_ingrediente, receita_ingrediente.quantidade FROM receitas
        INNER JOIN receita_ingrediente
        ON receitas.id_receita = receita_ingrediente.id_receita";
        $resultado = mysqli_query($con, $sql);
        if (mysqli_num_rows($resultado) == 0){
            echo "Erro: Receita Não Encontrada";
            return;
        }
        while ($linha = mysqli_fetch_assoc($resultado)){
        echo "---------------------------------------------------------\n";
        echo "\n[1] Titulo:  " . $linha["nome"];
        echo "\n[2] Tempo de Preparação:  " . $linha["prep"];
        echo "\n[3] Dose Esperada:  " . $linha["dose"];
        echo "\t[4] Ingredientes:  " . $linha["id_ingrediente"] . $linha["quantidade"];
        echo "\n[5] Categoria:  " . $linha["id_categoria"];
        echo "\n[6] Receita:  " . $linha["descricao"];
        echo "---------------------------------------------------------\n";
         $edit = readline("\n\nQue secção deseja editar? ");

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
            case 4:
                seeIngredientes($con,false);
                $novoIngrediente = readline("Novo Ingrediente: ");
                $sql = "UPDATE receita_ingrediente ADD id_ingrediente = '$novoIngrediente' WHERE id_receita = $id";
                $novaQuantidade = readline("Novo Ingrediente: ");
                $sql = "UPDATE receita_ingrediente ADD quantidade = '$novaQuantidade' WHERE id_receita = $id";
                break;
            case 5:
                seeCategorias($con,false);
                $novaCategoria = readline("Nova Categoria: ");
                $sql = "UPDATE receita_categoria ADD id_categoria = '$novaCategoria' WHERE id_receita = $id";
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
        echo "Successo: Livro Atualizado.";
        } if ($voltar){
        Voltar();
        } 
}



///////////////////
// CRUD - DELETE //
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


//apagar receita sem apagar ingrdientes ou categorias (INCOMPLETO)
function delReceita($con){
    seeReceita($con, false);
    $id = readline("ID da Receita que Deseja Apagar: ");
    $sql = "SELECT id FROM receitas WHERE id = $id";
    $valid = mysqli_query($con, $sql);
    if (mysqli_num_rows ($valid) == 0){
        echo ("Erro: Receita Não Encontrada");
        return;
    }
    $sql = "DELETE FROM receitas WHERE id = $id";
    mysqli_query($con, $sql);
    echo "Sucesso: Receita Removida";  
}




//encerrar a conexão
$bye = mysqli_close($con);
if ($bye){
    echo "\nPrograma Terminado!\n";
} else {
    echo "\nErro a encerrar conexão com a base de dados\n";
}