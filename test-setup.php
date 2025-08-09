<?php
// test-setup-fixed.php
echo "🔍 Diagnóstico del entorno de testing (CORREGIDO)\n\n";

// Verificar PHP
echo "PHP Version: " . PHP_VERSION . "\n";

// Verificar Composer
if (file_exists('vendor/autoload.php')) {
    echo "✅ Composer autoload encontrado\n";
    require_once 'vendor/autoload.php';
} else {
    echo "❌ Composer autoload NO encontrado\n";
    echo "   Ejecuta: composer install\n";
}

// Verificar PHPUnit
if (file_exists('vendor/bin/phpunit')) {
    echo "✅ PHPUnit binario encontrado\n";
} else {
    echo "❌ PHPUnit binario NO encontrado\n";
}

// Verificar archivos de configuración en múltiples ubicaciones
$configLocations = [
    'phpunit.xml' => 'Raíz del proyecto',
    'tests/phpunit.xml' => 'Carpeta tests',
    'phpunit.xml.dist' => 'Archivo de distribución'
];

$phpunitConfigFound = false;
foreach ($configLocations as $file => $location) {
    if (file_exists($file)) {
        echo "✅ PHPUnit config encontrado en: $location ($file)\n";
        $phpunitConfigFound = $file;
    }
}

if (!$phpunitConfigFound) {
    echo "❌ No se encontró configuración de PHPUnit\n";
}

// Verificar estructura de tests
$testDirs = ['tests/unit/php', 'tests/integration', 'tests/e2e'];
foreach ($testDirs as $dir) {
    if (is_dir($dir)) {
        echo "✅ Directorio $dir existe\n";
    } else {
        echo "❌ Directorio $dir NO existe\n";
    }
}

echo "\n🚀 Comandos sugeridos:\n";

if ($phpunitConfigFound) {
    if ($phpunitConfigFound === 'tests/phpunit.xml') {
        echo "1. php vendor/bin/phpunit -c tests/phpunit.xml\n";
        echo "2. O mover: mv tests/phpunit.xml ./phpunit.xml\n";
    } else {
        echo "1. php vendor/bin/phpunit\n";
    }
} else {
    echo "1. Crear phpunit.xml en la raíz\n";
}

echo "3. composer test (si está configurado)\n";

// Probar ejecución
echo "\n🧪 Probando ejecución de PHPUnit...\n";

if ($phpunitConfigFound === 'tests/phpunit.xml') {
    $command = 'php vendor/bin/phpunit -c tests/phpunit.xml --version 2>&1';
} else {
    $command = 'php vendor/bin/phpunit --version 2>&1';
}

$output = shell_exec($command);
if ($output) {
    echo "✅ PHPUnit responde:\n$output\n";
} else {
    echo "❌ PHPUnit no responde\n";
}
?>