const fs = require('fs');
let content = fs.readFileSync('resources/views/livewire/kasir/pos-page.blade.php', 'utf8');

content = content.replace(/text-white/g, 'text-main');

content = content.replace(/bg-brand-600(.*?)(hover:bg-brand-500)?(.*?)text-main/g, 'bg-brand-600$1$2$3text-white');
content = content.replace(/bg-orange-600(.*?)text-main/g, 'bg-orange-600$1text-white');
content = content.replace(/bg-green-600(.*?)text-main/g, 'bg-green-600$1text-white');
content = content.replace(/bg-emerald-500(.*?)text-main/g, 'bg-emerald-500$1text-white');
content = content.replace(/bg-emerald-600(.*?)text-main/g, 'bg-emerald-600$1text-white');
content = content.replace(/bg-indigo-600 text-main/g, 'bg-indigo-600 text-white');
content = content.replace(/bg-pink-600 text-main/g, 'bg-pink-600 text-white');
content = content.replace(/bg-orange-600 text-main/g, 'bg-orange-600 text-white');
content = content.replace(/bg-teal-600 text-main/g, 'bg-teal-600 text-white');
content = content.replace(/bg-fuchsia-600 text-main/g, 'bg-fuchsia-600 text-white');
content = content.replace(/hover:text-main/g, 'hover:text-white'); // hover:text-white is used for some dark buttons
content = content.replace(/dark:text-white/g, 'dark:text-white');

fs.writeFileSync('resources/views/livewire/kasir/pos-page.blade.php', content);
console.log('Fixed');
