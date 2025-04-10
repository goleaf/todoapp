#!/bin/bash

echo "Updating component references in blade templates..."

# Array of common component types to check
COMPONENTS=(
  "input"
  "button"
  "label"
  "form"
  "select"
  "textarea"
  "checkbox"
  "radio"
  "table"
  "link"
  "card"
  "error"
  "action-message"
  "danger-button"
  "secondary-button"
  "modal"
  "dropdown"
  "icon"
  "badge"
  "pagination"
)

# For each component type, find and update references
for component in "${COMPONENTS[@]}"; do
  echo "Checking for $component components..."
  
  # Find files using the component format <x-componentname
  grep_pattern="<x-$component\\b"
  files=$(grep -l "$grep_pattern" $(find resources/views -name "*.blade.php") 2>/dev/null)
  
  if [ -n "$files" ]; then
    echo "Found files using $component component:"
    echo "$files"
    
    # For each file, update the component references
    for file in $files; do
      echo "Updating $component references in $file"
      
      # Update opening tags - use different patterns based on component type
      case $component in
        "input"|"label"|"select"|"textarea"|"checkbox"|"radio")
          # These should go to form subdirectory
          sed -i "s/<x-$component\\b/<x-form.$component/g" "$file"
          ;;
        "button"|"danger-button"|"secondary-button")
          # These should go to buttons subdirectory
          sed -i "s/<x-$component\\b/<x-button.$component/g" "$file"
          ;;
        "table"|"pagination")
          # These should go to table subdirectory
          sed -i "s/<x-$component\\b/<x-table.$component/g" "$file"
          ;;
        "link"|"card"|"modal"|"dropdown"|"icon"|"badge")
          # These should go to ui subdirectory
          sed -i "s/<x-$component\\b/<x-ui.$component/g" "$file"
          ;;
        "error"|"action-message")
          # These should go to form subdirectory
          sed -i "s/<x-$component\\b/<x-form.$component/g" "$file"
          ;;
        *)
          # Default case - use the component name as subdirectory
          sed -i "s/<x-$component\\b/<x-$component.index/g" "$file"
          ;;
      esac
      
      # Update closing tags for components that have them
      if [[ "$component" != "input" && "$component" != "label" && "$component" != "error" ]]; then
        # Determine the appropriate prefix based on the component type
        case $component in
          "button"|"danger-button"|"secondary-button")
            prefix="button"
            ;;
          "table"|"pagination")
            prefix="table"
            ;;
          "link"|"card"|"modal"|"dropdown"|"icon"|"badge")
            prefix="ui"
            ;;
          "select"|"textarea"|"checkbox"|"radio"|"action-message")
            prefix="form"
            ;;
          *)
            prefix="$component"
            ;;
        esac
        
        # Apply the appropriate closing tag update
        case $component in
          "button"|"danger-button"|"secondary-button"|"table"|"pagination"|"link"|"card"|"modal"|"dropdown"|"icon"|"badge"|"select"|"textarea"|"checkbox"|"radio"|"action-message")
            sed -i "s|</x-$component>|</x-$prefix.$component>|g" "$file"
            ;;
          *)
            sed -i "s|</x-$component>|</x-$component.index>|g" "$file"
            ;;
        esac
      fi
    done
  else
    echo "No files found using $component component"
  fi
done

echo "Component reference updates complete!" 