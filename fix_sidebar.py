import re

path = 'w:/xampp_8_1_10/htdocs/rytoyu/resources/views/admin/layouts/sidebar.blade.php'
with open(path, 'r', encoding='utf-8') as f:
    content = f.read()

# Replace <a href="{{ route('ROUTE_NAME') }}" class="{{ isSubMenuActive('SOMETHING') }}">
def replace_sub_menu(match):
    full_match = match.group(0)
    route_name = match.group(1)
    
    # We replace the class with Route::is('route_name')
    new_class = f"{{{{ Route::is('{route_name}') ? 'active mm-active' : '' }}}}"
    
    # Replace the isSubMenuActive part with our new class logic inside the full match string
    # Warning: simple regex replacement to ensure we don't accidentally overwrite something
    return re.sub(r'\{\{\s*isSubMenuActive\([^\)]+\)\s*\}\}', new_class, full_match)

content = re.sub(r'<a\s[^>]*href=\"\{\{\s*route\(\'([^\']+)\'.*?\)\s*\}\}\"[^>]*class=\"\{\{\s*isSubMenuActive\([^\)]+\)\s*\}\}\"[^>]*>', replace_sub_menu, content)

with open(path, 'w', encoding='utf-8') as f:
    f.write(content)

print("Done")
