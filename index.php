<?php
// Simular um sistema de reservas com limite de vagas e fila de espera.

// Enquanto o usuário não escolher "sair":
//     Mostrar o menu:
//         1 - Fazer reserva
//         2 - Cancelar reserva
//         3 - Mostrar listas
//         4 - Sair

//     Ler a opção do usuário!!!

//     Se for 1:
//         Pedir o nome
//         Verificar se há vaga;
//         Se sim, adicionar na lista de reservas;
//         Se não, adicionar na fila de espera;

//     Se for 2:
//         Pedir o nome;
//         Verificar se existe algum registro na array;
//         Remover da lista de reservas;
//         Se tiver alguém na fila de espera, mover o primeiro para as reservas;

//     Se for 3:
//         Mostrar a lista de reservas e a fila de espera;

//     Se for 4:
//         Finalizar o loop e encerrar o programa;

// -----------------------------------------------------------------------------------------------
// INICIALIZAÇÃO DAS VARIÁVEIS GLOBAIS;
$reservas = [];
$filaEspera = [];

# Passar as variáveis por referência ou no escopo global!
# Quando se passar a variavel 'bruta' dentro dos parâmetros de uma função, ele simplismente cria uma cópia 
# da array ou valor, onde qualquer valor alterado dentro da função, não irá para a variável global!!!

// FUNÇÃO PARA GERENCIAR AS RESERVAS
function fazerReserva()
{
    global $reservas, $filaEspera;
    $limiteReserva = 5;

    echo "Informe seu nome para fazer a reserva" . PHP_EOL;
    $lugarReservado = readline();

    // Verifica se a quantidade de valores dentro da array reservas é menor que o limite definido;
    if (count($reservas) < $limiteReserva) {
        array_push($reservas, $lugarReservado); // Aloca ao final da array o dado do usuário caso haja vaga;
        echo "\n✅LUGAR RESERVADO COM SUCESSO" . PHP_EOL;
    } else {
        #Adiciono na fila de espera
        array_push($filaEspera, $lugarReservado); // Aloca ao final da array o dado do usuário caso NÃO haja vaga nas reservas;
        echo "\nLIMITE ATINGIDO - VOCÊ FOI ADICIONADO NA FILA DE ESPERA 🕒" . PHP_EOL;
    }

    echo "\nFazer mais reservas ? " . PHP_EOL . "==> ";
    $decisao = readline();
    $decisao = strtolower($decisao);
    while($decisao == "sim" or $decisao == "yes"){
        return fazerReserva();
    }
}
// fazerReserva();
// --------------------------------------------------------------------------------------------

// FUNÇÃO PARA IMPRESSÃO DE LISTA DE RESERVAS E FILA DE ESPERA
function imprimirLista($reservas, $filaEspera)
{ 
    echo "------------------------";
    echo "\n=== LISTA DE RESERVAS ===\n";
    foreach ($reservas as $nomes) { // Percorre todos os dados da lista de RESERVAS e imprimi os valores;
        echo "|  $nomes" . PHP_EOL;
    }
    
    echo "\n=== LISTA DE ESPERA ===\n";
    foreach ($filaEspera as $nomes) { // Percorre todos os dados da lista de ESPERA e imprimi os valores;
        echo "|  $nomes" . PHP_EOL;
    }
    echo "------------------------";

}
// imprimirLista($reservas, $filaEspera);

// --------------------------------------------------------------------------------------------

// FUNÇÃO PRA CANCELAMENTO DE RESERVAS
function cancelarReserva()
{
    global $reservas, $filaEspera;

    if(empty($reservas)){
         echo "❗NÃO HÁ RESERVAS PARA CANCELAR❗" . PHP_EOL;
        return false;
    }

    imprimirLista($reservas, $filaEspera);
    echo "\nInforme o nome para cancelar() reserva: " . PHP_EOL;
    $nomeCancelado = readline();

    // Busca o indice correspondente a entrada do usuário
    $key = array_search($nomeCancelado, $reservas);
    if ($key !== false) {
        unset($reservas[$key]); // Cancela na array reservas, o índice correspondente a entrada do usuário;
        echo "\n✅ RESERVA DE ($nomeCancelado) CANCELADA!!!." . PHP_EOL;
    } else {
        echo "❗NOME NÃO ENCONTRADO❗\n";
        return cancelarReserva();
    }

    //  Se tiver alguém na fila de espera, mover o primeiro para as reservas
    if (!empty($filaEspera)) {
        $proxima = array_shift($filaEspera);    // Retira da esquerda da array e aloca na variavel (PROXIMA);
        $reservas[] = $proxima;                 // Pega o valor de (PROXIMO) e aloca dentro das RESERVAS;
        imprimirLista($reservas, $filaEspera);  // iMPRIMI;
    }
}
// cancelarReserva();

// --------------------------------------------------------------------------------------------

function exibirMenu()
{
    echo "\n=== MENU ===\n";
    echo "1 - 📅 Fazer reserva" . PHP_EOL;
    echo "2 - ❌ Cancelar reserva" . PHP_EOL;
    echo "3 - 📋 Mostrar listas" . PHP_EOL;
    echo "4 - 📤 Sair" . PHP_EOL . "==> ";
}
// exibirMenu();
// ---------------------------------------------------------------------------------------------

function executarPrograma(){
    global $reservas, $filaEspera;

    while (true) {
        exibirMenu();
        $decisao = (int) readline();
        switch ($decisao) {
            case 1:
                fazerReserva();
                break;
            case 2:
                cancelarReserva();
                break;
            case 3:
                imprimirLista($reservas, $filaEspera);
                break;
            case 4:
                break;
            default:
                echo "Opção inválida";
                break;
        }
    }
}

executarPrograma();