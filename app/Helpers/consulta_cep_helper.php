<?php

if (!function_exists('consultaCep'))
{

    function consultaCep(string $cep)
    {
        $urlViaCep = "https://viacep.com.br/ws/{$cep}/json/";

        /*
         * Abre a conexão
         */
        $ch = curl_init();

        /*
         * Definindo a url
         */
        curl_setopt($ch, CURLOPT_URL, $urlViaCep);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        /*
         * Post
         */

        $json = curl_exec($ch);

        /*
         * Decodificando o bj json
         */

        $resultado = json_decode($json);

        /*
         * Fecha conm
         */

        return $resultado;
    }

}