<?php

namespace App\Support;

class CatalogIcons
{
    public static function svg(string $name): string
    {
        $icons = [
            'printing' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9V3h12v6"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="7"/></svg>',
            'scan' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 8V5a1 1 0 0 1 1-1h3"/><path d="M4 16v3a1 1 0 0 0 1 1h3"/><path d="M20 8V5a1 1 0 0 0-1-1h-3"/><path d="M20 16v3a1 1 0 0 1-1 1h-3"/><line x1="3" y1="12" x2="21" y2="12"/></svg>',
            'rushid' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="8" cy="12" r="2"/><line x1="13" y1="10" x2="18" y2="10"/><line x1="13" y1="14" x2="18" y2="14"/></svg>',
            'lamination' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="2"/><rect x="7" y="7" width="10" height="10" rx="1"/></svg>',
            'template' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7S9 2 6.5 3.5 6 8 12 7z"/><path d="M12 7s3-5 5.5-3.5S17.5 8 12 7z"/></svg>',
            'photo' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="10" r="1.5"/><path d="M21 16l-5.5-5.5L4 19"/></svg>',
            'photocopy' => '<svg viewBox="0 0 24 24" fill="none" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="7" y="3" width="10" height="14" rx="1"/><path d="M4 8v11a1 1 0 0 0 1 1h10"/></svg>',
        ];

        return $icons[$name] ?? $icons['photo'];
    }
}
