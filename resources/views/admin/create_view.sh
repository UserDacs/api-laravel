#!/bin/bash

# Ask for file name and feature name
read -p "Enter new file name (without .blade.php): " new_file
read -p "Enter feature name (e.g., User Profile): " feature_name

# Set the base path
BASE_PATH="/api-laravel"

# Ensure we're in the correct directory and run artisan commands
cd "$BASE_PATH" || { echo "Error: Could not change directory to $BASE_PATH"; exit 1; }

# Create the model and controller
php artisan make:controller "${feature_name}Controller" || { echo "Error: Failed to create controller."; exit 1; }
php artisan make:model "$feature_name" -m || { echo "Error: Failed to create model."; exit 1; }

# Handle the Blade view
cd "$BASE_PATH/resources/views/admin" || { echo "Error: Could not change to resources/views/admin"; exit 1; }

# Define paths
TEMPLATE="template.blade.php"
NEW_FILE="${new_file}.blade.php"

# Check if template exists
if [ ! -f "$TEMPLATE" ]; then
  echo "Error: $TEMPLATE does not exist in the current directory."
  exit 1
fi

# Copy the template and replace 'Template' with the feature name
cp "$TEMPLATE" "$NEW_FILE" || { echo "Error: Failed to copy template."; exit 1; }
sed -i "s/Template/$feature_name/g" "$NEW_FILE" || { echo "Error: Failed to replace template name."; exit 1; }

# Add the index method to the controller
CONTROLLER_PATH="$BASE_PATH/app/Http/Controllers/${feature_name}Controller.php"
ROUTES_PATH="$BASE_PATH/routes/web.php"

TAB=$'\t'

# Prepare method text and route text
METHOD_TEXT="${TAB}public function index() {\n${TAB}${TAB}return view('admin.${new_file}');\n${TAB}}"
ROUTE_TEXT="${TAB}Route::get('/admin-${new_file}', [App\\\\Http\\\\Controllers\\\\${feature_name}Controller::class, 'index'])->name('admin.${new_file}');"

# Insert index method before the closing } in the controller
sed -i "/^}/i\\
$METHOD_TEXT
" "$CONTROLLER_PATH" || { echo "Error: Failed to add index method in controller."; exit 1; }

# Insert route below the comment // newfile in routes/web.php
sed -i "/\/\/ newfile/a\\
$ROUTE_TEXT
" "$ROUTES_PATH" || { echo "Error: Failed to add route in web.php."; exit 1; }

echo "✅ File created: $NEW_FILE with feature name: $feature_name"
echo "✅ Controller created with index method added inside the class."
echo "✅ Route added below // newfile in web.php."
