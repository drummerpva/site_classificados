<?php
    class Anuncios{
        
        public function getTotalAnuncios($filtros){
            global $pdo;
            $filtroString = array("1=1");
            if(!empty($filtros['categoria'])){
                $filtroString[] = "a.id_categoria = :id_categoria";
            }
            if(!empty($filtros['preco'])){
                $filtroString[] = "a.valor BETWEEN :preco1 AND :preco2";
            }
            if(!empty($filtros['estado'])){
                $filtroString[] = "a.estado = :estado";
            }


            $sql = $pdo->prepare("SELECT count(1) as total FROM anuncios a WHERE ". implode(" AND ", $filtroString));

            if(!empty($filtros['categoria'])){
                $sql->bindValue(":id_categoria",$filtros['categoria']);
            }
            if(!empty($filtros['preco'])){
                $preco = explode("-",$filtros['preco']);
                $sql->bindValue(":preco1",$preco[0]);
                $sql->bindValue(":preco2",$preco[1]);
            }
            if(!empty($filtros['estado'])){
                $sql->bindValue(":estado",$filtros['estado']);
            }
            $sql->execute();

            if($sql->rowCount()>0){
                $sql = $sql->fetch();
                return $sql['total'];
            }
        }
        
        public function getMeusAnuncios($id){
            global $pdo;
            $array = array();
            $sql = $pdo->prepare("SELECT a.*, (SELECT ai.url FROM anuncios_imagens ai WHERE ai.id_anuncio = a.id LIMIT 1 ) as url FROM anuncios a WHERE id_usuario = :id");
            $sql->bindValue(":id",$id);
            $sql->execute();
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll();
            }
            return $array;
        }
        public function getUltimosAnuncios($page,$perPage,$filtros){
            global $pdo;
            $offset = ($page - 1) * $perPage;
            $array = array();
            $filtroString = array("1=1");
            if(!empty($filtros['categoria'])){
                $filtroString[] = "a.id_categoria = :id_categoria";
            }
            if(!empty($filtros['preco'])){
                $filtroString[] = "a.valor BETWEEN :preco1 AND :preco2";
            }
            if(!empty($filtros['estado'])){
                $filtroString[] = "a.estado = :estado";
            }
            
            
            $sql = $pdo->prepare("SELECT a.*, (SELECT ai.url FROM anuncios_imagens ai WHERE ai.id_anuncio = a.id LIMIT 1 ) as url, "
                    . "(SELECT c.nome FROM categorias c WHERE c.id = a.id_categoria) as categoria FROM anuncios a "
                    . "WHERE ". implode(" AND ", $filtroString)." ORDER BY a.id DESC LIMIT $offset,2");
            if(!empty($filtros['categoria'])){
                $sql->bindValue(":id_categoria",$filtros['categoria']);
            }
            if(!empty($filtros['preco'])){
                $preco = explode("-",$filtros['preco']);
                $sql->bindValue(":preco1",$preco[0]);
                $sql->bindValue(":preco2",$preco[1]);
            }
            if(!empty($filtros['estado'])){
                $sql->bindValue(":estado",$filtros['estado']);
            }
            
            $sql->execute();
            if($sql->rowCount() > 0){
                $array = $sql->fetchAll();
            }
            return $array;
        }
        
        
        
        public function alterarAnuncio($idAnuncio,$categoria,$titulo,$valor,$descricao,$estado,$fotos){
            global $pdo;
            $sql = $pdo->prepare("UPDATE anuncios SET id_categoria=:categoria, titulo=:titulo, valor=:valor, descricao=:descricao, estado=:estado WHERE id = :id");
            $sql->bindValue(":categoria",$categoria);
            $sql->bindValue(":titulo",$titulo);
            $sql->bindValue(":valor",$valor);
            $sql->bindValue(":descricao",$descricao);
            $sql->bindValue(":estado",$estado);
            $sql->bindValue(":id",$idAnuncio);
            $sql->execute();
            
            if(count($fotos) > 0){
                for($q=0;$q<count($fotos['tmp_name']);$q++){
                    $tipo = $fotos['type'][$q];
                    if(in_array($tipo, array("image/jpeg","image/png","image/jpg"))){
                        $tmpName = md5(time().rand(0,9999)).".jpg";
                        move_uploaded_file($fotos['tmp_name'][$q], "images/anuncios/".$tmpName);
                        list($largO,$altO) = getimagesize("images/anuncios/".$tmpName);
                        $ratio = $largO/$altO;
                        $larg = 500;
                        $alt = 500;
                        if($larg/$alt > $ratio){
                            $larg = $alt * $ratio;
                        }else{
                            $alt = $larg / $ratio;
                        }
                        $img = imagecreatetruecolor($larg, $alt);
                        if($tipo == "image/jpeg"){
                            $origi = imagecreatefromjpeg("images/anuncios/".$tmpName);
                        }elseif($tipo == "image/png"){
                            $origi = imagecreatefrompng("images/anuncios/".$tmpName);
                        }
                        imagecopyresampled($img, $origi, 0, 0, 0, 0, $larg, $alt, $largO, $altO);
                        imagejpeg($img,"images/anuncios/".$tmpName,80);
                        
                        $sql = $pdo->prepare("INSERT INTO anuncios_imagens SET id_anuncio = :id, url = :url");
                        $sql->bindValue(":id",$idAnuncio);
                        $sql->bindValue(":url",$tmpName);
                        $sql->execute();
                    }
                }
            }
            
        }
        
        
        
        
        
        public function inserirAnuncio($idUsuario,$categoria,$titulo,$valor,$descricao,$estado){
            global $pdo;
            $sql = $pdo->prepare("INSERT INTO anuncios SET id_usuario= :usuario, id_categoria=:categoria, titulo=:titulo, valor=:valor, descricao=:descricao, estado=:estado");
            $sql->bindValue(":usuario",$idUsuario);
            $sql->bindValue(":categoria",$categoria);
            $sql->bindValue(":titulo",$titulo);
            $sql->bindValue(":valor",$valor);
            $sql->bindValue(":descricao",$descricao);
            $sql->bindValue(":estado",$estado);
            $sql->execute();
        }
        public function excluirAnuncio($id){
            global $pdo;
            $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id_anuncio = ?");
            $sql->execute(array($id));
            $sql = $pdo->prepare("DELETE FROM anuncios WHERE id = ?");
            $sql->execute(array($id));
        }
        
        public function excluirFoto($id){
            global $pdo;
            $idAnuncio = 0;
            $sql = $pdo->prepare("SELECT id_anuncio, url FROM anuncios_imagens WHERE id = ?");
            $sql->execute(array($id));
            if($sql->rowCount() > 0){
                $sql = $sql->fetch();
                unlink("./images/anuncios/".$sql['url']);
                $idAnuncio = $sql['id_anuncio'];
            }
            
            $sql = $pdo->prepare("DELETE FROM anuncios_imagens WHERE id = ?");
            $sql->execute(array($id));
            
            return $idAnuncio;
            
        }
        
        
        public function getAnuncio($id){
            global $pdo;
            $array = array();
            $sql = $pdo->prepare("SELECT a.*,(SELECT c.nome FROM categorias c WHERE c.id = a.id_categoria) as categoria"
                    . ", (SELECT u.telefone FROM usuarios u WHERE u.id = a.id_usuario) as telefone FROM anuncios a WHERE a.id = ?");
            $sql->execute(array($id));
            if($sql->rowCount()>0){
                $array = $sql->fetch();
                $array['fotos'] = array();
                $sql = $pdo->prepare("SELECT id,url FROM anuncios_imagens WHERE id_anuncio = :id");
                $sql->bindValue(":id",$id);
                $sql->execute();
                if($sql->rowCount()>0){
                    $array['fotos'] = $sql->fetchAll();
                }
            }
            return $array;
        }
    }