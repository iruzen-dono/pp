<?php
namespace Tests\Unit;

use App\Core\Model;

/**
 * ModelTest - Basic Model class tests
 * Note: PHPUnit tests require Composer: composer install
 * For basic tests without PHPUnit, run: php tests/Unit/ModelTest.php
 */
class ModelTest
{
    /**
     * Test that Model class exists and is loadable
     */
    public static function testModelExists()
    {
        $modelClass = Model::class;
        
        if (!class_exists($modelClass)) {
            throw new \Exception("Model class not found: $modelClass");
        }
        
        echo "✓ Model class exists\n";
        return true;
    }

    /**
     * Test that Model has required methods
     */
    public static function testModelHasRequiredMethods()
    {
        $reflection = new \ReflectionClass(Model::class);
        $requiredMethods = ['run'];
        
        foreach ($requiredMethods as $method) {
            if (!$reflection->hasMethod($method)) {
                throw new \Exception("Required method not found: $method");
            }
        }
        
        echo "✓ Model has all required methods\n";
        return true;
    }

    /**
     * Run all tests
     */
    public static function runAll()
    {
        echo "\n=== Running Basic Model Tests ===\n";
        
        try {
            self::testModelExists();
            self::testModelHasRequiredMethods();
            echo "\n✓ All tests passed!\n\n";
            return true;
        } catch (\Exception $e) {
            echo "\n✗ Test failed: " . $e->getMessage() . "\n\n";
            return false;
        }
    }
}

// Run tests if executed directly
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['PHP_SELF'] ?? '')) {
    require_once __DIR__ . '/../../App/Core/Model.php';
    ModelTest::runAll();
}
