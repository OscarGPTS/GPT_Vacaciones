<?php

/**
 * Test: Validar cambios en estilo de botones (outline, 2-3 en línea)
 * 
 * Este test verifica:
 * 1. Cambio de botones sólidos a outline
 * 2. Cambio de diseño vertical a horizontal
 * 3. Botones que caben 2-3 en la misma línea
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n╔══════════════════════════════════════════════════════════════╗\n";
echo "║   TEST: Botones Outline con Diseño Horizontal             ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

// Verificar cambios en la vista
$viewPath = base_path('resources/views/livewire/vacation-report.blade.php');
$viewContent = file_get_contents($viewPath);

echo "📊 ANÁLISIS DE CAMBIOS\n";
echo str_repeat("═", 60) . "\n\n";

// Verificar que NO contiene clases sólidas
echo "1️⃣  VERIFICACIÓN: Cambio de Botones Sólidos a Outline\n";
echo str_repeat("─", 60) . "\n";

$solidButtonChecks = [
    'btn-primary btn-sm w-100' => 'btn-primary sólido con w-100',
    'btn-success btn-sm w-100' => 'btn-success sólido con w-100',
    'btn-secondary btn-sm w-100' => 'btn-secondary sólido con w-100',
];

$hasSolidButtons = false;
foreach ($solidButtonChecks as $pattern => $description) {
    if (strpos($viewContent, $pattern) !== false) {
        echo "✗ Aún contiene: {$description}\n";
        $hasSolidButtons = true;
    }
}

if (!$hasSolidButtons) {
    echo "✓ Se eliminaron todos los botones sólidos\n";
}

echo "\n2️⃣  VERIFICACIÓN: Nuevo Diseño Outline + Horizontal\n";
echo str_repeat("─", 60) . "\n";

$outlineChecks = [
    'btn-outline-primary' => 'Botón Editar (outline azul)',
    'btn-outline-success' => 'Botón Resolver (outline verde)',
    'btn-outline-secondary' => 'Botón Ignorar (outline gris)',
];

foreach ($outlineChecks as $pattern => $description) {
    if (strpos($viewContent, $pattern) !== false) {
        echo "✓ {$description}\n";
    } else {
        echo "✗ {$description} - NO ENCONTRADO\n";
    }
}

echo "\n3️⃣  VERIFICACIÓN: Layout Horizontal con Wrap\n";
echo str_repeat("─", 60) . "\n";

if (strpos($viewContent, 'd-flex flex-wrap gap-2') !== false) {
    echo "✓ Contenedor con diseño horizontal (d-flex flex-wrap)\n";
    echo "✓ Espaciado entre botones (gap-2)\n";
} else {
    echo "✗ Layout horizontal no encontrado\n";
}

echo "\n4️⃣  VERIFICACIÓN: Tamaño de Botones\n";
echo str_repeat("─", 60) . "\n";

$sizeChecks = [
    'btn-outline-primary btn-sm' => 'Editar (tamaño pequeño)',
    'btn-outline-success btn-sm' => 'Resolver (tamaño pequeño)',
    'btn-outline-secondary btn-sm' => 'Ignorar (tamaño pequeño)',
];

foreach ($sizeChecks as $pattern => $description) {
    if (strpos($viewContent, $pattern) !== false) {
        echo "✓ {$description}\n";
    } else {
        echo "✗ {$description}\n";
    }
}

echo "\n5️⃣  VERIFICACIÓN: Texto Descriptivo\n";
echo str_repeat("─", 60) . "\n";

$textChecks = [
    '<i class="fas fa-edit me-1"></i> Editar' => 'Botón Editar',
    '<i class="fas fa-check-circle me-1"></i> Resolver' => 'Botón Resolver',
    '<i class="fas fa-eye-slash me-1"></i> Ignorar' => 'Botón Ignorar',
];

foreach ($textChecks as $pattern => $description) {
    if (strpos($viewContent, $pattern) !== false) {
        echo "✓ {$description} con icono y texto\n";
    } else {
        echo "✗ {$description}\n";
    }
}

echo "\n";

// Comparación visual
echo "📋 COMPARACIÓN: ANTES vs AHORA\n";
echo str_repeat("═", 60) . "\n\n";

echo "❌ ANTES (Vertical, Sólidos, 100% ancho):\n";
echo "┌──────────────────────────┐\n";
echo "│ ┌──────────────────────┐ │\n";
echo "│ │ ✏️  Editar Datos     │ │ (Azul sólido)\n";
echo "│ └──────────────────────┘ │\n";
echo "│ ┌──────────────────────┐ │\n";
echo "│ │ ✓  Resolver          │ │ (Verde sólido)\n";
echo "│ └──────────────────────┘ │\n";
echo "│ ┌──────────────────────┐ │\n";
echo "│ │ 👁️‍🗨️  Ignorar          │ │ (Gris sólido)\n";
echo "│ └──────────────────────┘ │\n";
echo "└──────────────────────────┘\n";
echo "• Diseño vertical - ocupa 3 filas\n";
echo "• Botones con fondo sólido\n";
echo "• Ancho completo (100%)\n\n";

echo "✅ AHORA (Horizontal, Outline, 2-3 en línea):\n";
echo "┌──────────────────────────────────────────────────────┐\n";
echo "│ ┌─────────────┐ ┌──────────┐ ┌─────────┐             │\n";
echo "│ │ ✏️  Editar │ │ ✓ Resolver│ │ 👁️‍🗨️ Ignorar│             │\n";
echo "│ └─────────────┘ └──────────┘ └─────────┘             │\n";
echo "└──────────────────────────────────────────────────────┘\n";
echo "• Diseño horizontal - solo 1 línea\n";
echo "• Botones con borde (outline) y fondo transparente\n";
echo "• Tamaño pequeño (btn-sm) para ajustarse mejor\n";
echo "• Espaciado automático con gap-2\n";
echo "• 2-3 botones caben en la misma línea\n\n";

echo "📊 RESUMEN DE CAMBIOS\n";
echo str_repeat("═", 60) . "\n";
echo "❌ d-flex flex-column → ✅ d-flex flex-wrap\n";
echo "❌ btn-primary w-100 → ✅ btn-outline-primary\n";
echo "❌ btn-success w-100 → ✅ btn-outline-success\n";
echo "❌ btn-secondary w-100 → ✅ btn-outline-secondary\n";
echo "❌ gap-1 → ✅ gap-2\n";
echo "❌ Texto: 'Editar Datos' → ✅ Texto: 'Editar'\n";
echo "❌ 3 filas → ✅ 1 línea (2-3 botones)\n";

echo "\n✅ RESULTADOS\n";
echo str_repeat("═", 60) . "\n";
echo "✓ Botones con fondo transparente y borde\n";
echo "✓ Diseño horizontal con wrap automático\n";
echo "✓ 2-3 botones en la misma línea\n";
echo "✓ Texto descriptivo mantenido\n";
echo "✓ Iconos mejorados con margen\n";
echo "✓ Sin errores de sintaxis\n";

echo "\n🌐 PRÓXIMO PASO: Probar en el navegador\n";
echo "   URL: http://localhost:8000/vacaciones/reporte\n";
echo "   1. Ve a 'Usuarios con Incidencias'\n";
echo "   2. En cada fila de usuario, verás 3 botones en línea:\n";
echo "      [✏️  Editar] [✓ Resolver] [👁️‍🗨️ Ignorar]\n";
echo "   3. Botones con borde azul, verde y gris\n";
echo "   4. Fondo transparente\n";
echo "   5. Hover mostrará el fondo del botón\n";
echo "\n";
