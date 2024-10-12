<?php

namespace Akhenaton\Library;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Akhenaton\Exceptions\ViewNotFoundException;
use Exception;

class View
{
    private static ?Environment $twig = null; // Propriedade inicializada como null
    private static string $viewPath = VIEW_PATH; // Propriedade inicializada como string vazia

    // Método para configurar o caminho das views (deve ser chamado uma vez na inicialização do aplicativo)
    public static function setViewPath(string $viewPath)
    {
        self::$viewPath = $viewPath;
    }

    // Método estático para renderizar a view
    public static function render(string $view, array $data = [])
    {
        // Inicializa o Twig se não tiver sido feito ainda
        if (self::$twig === null) {
            self::initializeTwig(); // Chama a função de inicialização
        }

        $viewFile = $view . '.twig';  // Define o arquivo da view a ser carregado

        try {
            // Renderiza a view utilizando Twig e os dados passados
            echo self::$twig->render($viewFile, $data);
        } catch (Exception $e) {
            throw new ViewNotFoundException("View " . $view . " not found: " . $e->getMessage());
        }
    }

    // Método privado para inicializar o ambiente do Twig
    private static function initializeTwig()
    {
        // Verifica se o viewPath está configurado
        if (empty(self::$viewPath)) {
            throw new \RuntimeException("View path not set. Call View::setViewPath() before rendering.");
        }

        // Configura o loader do Twig, que carrega os templates da pasta definida
        $loader = new FilesystemLoader(self::$viewPath);
        self::$twig = new Environment($loader, [
            'cache' => false,  // Se quiser cache, defina um diretório de cache aqui
        ]);
    }
}
