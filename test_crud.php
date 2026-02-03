&lt;?php

/**
* Test script to verify CRUD operations work
* Run with: php test_crud.php
*/

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Client;
use App\Models\Project;

echo "=== Testing CRUD Operations ===\n\n";

// Test 1: Create a Client
echo "Test 1: Creating a new client...\n";
try {
$client = Client::create([
'name' => 'Test Client ' . time(),
'company' => 'Test Company',
'contact_person' => 'John Doe',
'email' => 'test@example.com',
'phone' => '+33 1 23 45 67 89',
]);
echo "✓ Client created successfully! ID: {$client->id}\n";

// Test 2: Update the Client
echo "\nTest 2: Updating the client...\n";
$client->update(['company' => 'Updated Company']);
echo "✓ Client updated successfully!\n";

// Test 3: Create a Project for this Client
echo "\nTest 3: Creating a new project...\n";
$project = Project::create([
'client_id' => $client->id,
'name' => 'Test Project ' . time(),
'description' => 'This is a test project',
'status' => 'prospect',
'priority' => 'medium',
]);
echo "✓ Project created successfully! ID: {$project->id}\n";

// Test 4: Update the Project
echo "\nTest 4: Updating the project...\n";
$project->update(['status' => 'in_progress']);
echo "✓ Project updated successfully!\n";

// Test 5: Read operations
echo "\nTest 5: Reading data...\n";
$clientFromDb = Client::find($client->id);
echo "✓ Client found: {$clientFromDb->name} - {$clientFromDb->company}\n";

$projectFromDb = Project::find($project->id);
echo "✓ Project found: {$projectFromDb->name} - Status: {$projectFromDb->status}\n";

// Clean up
echo "\nCleaning up test data...\n";
$project->delete();
$client->delete();
echo "✓ Test data cleaned up\n";

echo "\n=== ALL TESTS PASSED ===\n";

} catch (\Exception $e) {
echo "✗ Error: " . $e->getMessage() . "\n";
echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
exit(1);
}