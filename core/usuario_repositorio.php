<?php
    session_start();
    require_once '../includes/funcoes.php';
    require_once 'conexao_mysql.php';
    require_once 'sql.php';
    require_once 'mysql.php';
    $salt = '$1$somethin$';

    foreach ($_POST as $indice => $dado){
        $$indice = limparDados($dado);
    }

    foreach ($_GET as $indice => $dado){
        $$indice = limparDados($dado);
    }

    switch ($acao){
        case 'insert':
            $dados = [
                'nome' => $nome,
                'email' => $email,
                'senha' => crypt($senha, $salt)
            ];
            insere(
                'usuario', 
                $dados
            );

            break;
        case 'update':
            $id = (int)$id;
            $dados = [
                'nome' => $nome,
                'email' => $email
            ];

            $criterio = [
                ['id', '=', $id]
            ];

            atualiza(
                'usuario',
                $dados,
                $criterio
            );
            break;

            case 'login':
                $criterio = [
                    ['email', '=', $email],
                    ['AND', 'ativo', '=', 1]
                ];
                
                $retorno = buscar (
                    'usuario',
                    ['id', 'nome', 'email', 'senha', 'adm'],
                    $criterio
                );

                if(count($retorno)>0){
                    if(crypt($senha, $salt) == $retorno[0]['senha']){
                        $_SESSION['login']['usuario'] = $retorno[0];
                        if(!empty($_SESSION['url_retorno'])){
                            header ('Localition: ' . $_SESSION ['url_retorno']);
                            $_SESSION ['url_retorno'] = '';
                            exit;
                        }
                    }
                }
                break;

                case 'logout': 
                    session_destroy();
                    break;

                case 'status':
                    $id = (int)$id;
                    $valor = (int)$valor;

                    $dados = [
                        'ativo' => $valor
                    ];

                    $criterio = [
                        ['id', '=', $id]
                    ];

                    atualiza(
                        'usuario',
                        $dados,
                        $criterio
                    );

                    header('Location: ../usuarios.php');
                    exit;
                    break;

                    case 'adm':
                        $id = (int)$id;
                        $valor = (int)$valor;

                        $dados = [
                            'adm' => $valor 
                        ];

                        $criterio = [
                            [ 'id', '=', $id]
                        ];

                        atualiza( 
                            'usuario', $dados, $criterio
                        );

                        header('Location: ../usuarios.php');
                        exit;
                        break;
    }
    header('Location: ../index.php');
?>