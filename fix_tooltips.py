import os
import glob
import re

html_path = 'w:/xampp_8_1_10/htdocs/rytoyu/resources/views/admin'
files = glob.glob(os.path.join(html_path, '**/*.blade.php'), recursive=True)

# Regex to find <td>{{ $some_var->name ?? '' }}</td> or <td>{{ $some_var->name }}</td>
pattern = re.compile(r'<td>\s*\{\{\s*(\$[a-zA-Z0-9_]+->name(?:\s*\?\?\s*\'\')?)\s*\}\}\s*</td>')

total_replaced = 0
for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    def repl(match):
        var = match.group(1)
        return f'<td {{!! tooltip({var}) !!}}>{{{{ textLimit({var}) }}}}</td>'
        
    new_content, count = pattern.subn(repl, content)
    if count > 0:
        total_replaced += count
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Replaced {count} instances in {file}")

print(f"Total replaced: {total_replaced}")
