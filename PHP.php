<?php

// Função para fazer uma requisição para a PokeAPI e obter dados de um Pokémon
function getPokemonData($id) {
    $url = "https://pokeapi.co/api/v2/pokemon/{$id}";
    $response = file_get_contents($url);
    return json_decode($response);
}

// Verificar se o ID do Pokémon foi enviado via POST
if(isset($_POST['pokemon_id'])) {
    // Obter o ID do Pokémon do POST
    $pokemon_id = $_POST['pokemon_id'];

    // Obter os dados do Pokémon da API
    $pokemon_data = getPokemonData($pokemon_id);

    // Verificar se os dados foram obtidos com sucesso
    if($pokemon_data) {
        // Extrair informações relevantes do Pokémon
        $pokemon_name = $pokemon_data->name;
        $pokemon_id = $pokemon_data->id;
        $pokemon_types = implode(', ', array_map(function($type) {
            return $type->type->name;
        }, $pokemon_data->types));
        $pokemon_image = $pokemon_data->sprites->front_default;

        // Montar a linha da tabela com os dados do Pokémon
        $row = "<tr>";
        $row .= "<td>{$pokemon_id}</td>";
        $row .= "<td>{$pokemon_name}</td>";
        $row .= "<td>{$pokemon_types}</td>";
        $row .= "<td><img src='{$pokemon_image}' alt='{$pokemon_name}'></td>";
        $row .= "<td><button class='deleteBtn'>Excluir</button></td>";
        $row .= "</tr>";

        // Enviar a linha da tabela de volta para o front-end
        echo $row;
    } else {
        // Se ocorrer um erro ao obter os dados do Pokémon, retornar uma mensagem de erro
        echo "Erro ao obter os dados do Pokémon.";
    }
} else {
    // Se o ID do Pokémon não foi enviado, retornar uma mensagem de erro
    echo "ID do Pokémon não fornecido.";
}

?>
