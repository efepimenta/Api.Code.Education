<?php
namespace Digital\Service;

class UploadService
{

    private $arquivo;
    private $filename;
    private $erros;

    private $config;

    public function __construct($origem)
    {
        // Tamanho máximo do arquivo (em bytes)
        $this->config["tamanho"] = 106883;
        // Largura máxima (pixels)
        $this->config["largura"] = 350;
        // Altura máxima (pixels)
        $this->config["altura"] = 180;
        
        $this->arquivo = $origem;
    }
    
    // Verifica se o mime-type do arquivo é de imagem
    private function verificaMime()
    {
        if (!preg_match('/^image\/(pjpeg|jpeg|png|gif|bmp)$/i', $this->arquivo['imagem']['type'])) {
            $this->erros[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg,
			bmp, gif ou png. Envie outro arquivo - {$this->arquivo['imagem']['name']}";
            return false;
        }
        return true;
    }
    // Verifica tamanho do arquivo
    private function verificaTamanhoArquivo()
    {
        if ($this->arquivo['imagem']["size"] > $this->config["tamanho"]) {
            $this->erros[] = "Arquivo em tamanho muito grande!
		A imagem deve ser de no máximo " . $this->config["tamanho"] . " bytes.
		Envie outro arquivo";
            return false;
        }
        return true;
    }
    // verificar tamanhos de imagem
    private function verificaTamanhoImagem()
    {
        $tamanhos = getimagesize($this->arquivo['imagem']["tmp_name"]);
        
        // Verifica largura
        if ($tamanhos[0] > $this->config["largura"]) {
            $this->erros[] = "Largura da imagem não deve
				ultrapassar " . $this->config["largura"] . " pixels";
            return false;
        }
        
        // Verifica altura
        if ($tamanhos[1] > $this->config["altura"]) {
            $this->erros[] = "Altura da imagem não deve
				ultrapassar " . $this->config["altura"] . " pixels";
            return false;
        }
        return true;
    }

    public function upload()
    {
        if (!$this->verificaMime()){
            return false;
        };
        
//         if (!$this->verificaTamanhoArquivo()){
//             return false;
//         };
//         if (!$this->verificaTamanhoImagem()){
//             return false;
//         };

        // Pega extensão do arquivo
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $this->arquivo['imagem']["name"], $ext);
        
        // Gera um nome único para a imagem
        $imagem_nome = md5(uniqid(time())) . "." . $ext[1];
        
        // Caminho de onde a imagem ficará
        $imagem_dir = __DIR__ . '/../../../html/images/' . $imagem_nome;
        
        // Faz o upload da imagem
        try {
            move_uploaded_file($this->arquivo['imagem']["tmp_name"], $imagem_dir);
        } catch (Exception $e) {
            return $e->getMessage();
        }
        
        $this->filename = $imagem_nome;
        
        return true;
    }
    
    public function getFileName(){
        return 'images/' . $this->filename;
    }
    
    public function getErros(){
        foreach ($this->erros as $e){
            $er = $e . '<br>';
        }
        return $er;
    }
}
