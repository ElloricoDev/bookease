@props([
    'icon',
    'value',
    'label',
    'link' => null,
    'linkText' => null,
    'variant' => 'primary', // primary, danger, success, info, secondary
    'style' => 'gradient' // gradient, simple
])

@php
    $gradients = [
        'primary' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
        'danger' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
        'success' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)',
        'info' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)',
        'secondary' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)',
    ];
    $colors = [
        'primary' => '#2e7d32',
        'danger' => '#dc3545',
        'success' => '#28a745',
        'info' => '#17a2b8',
        'secondary' => '#ffc107',
    ];
    $gradient = $gradients[$variant] ?? $gradients['primary'];
    $color = $colors[$variant] ?? $colors['primary'];
@endphp

@if($style === 'simple')
    <div class="stat-card" style="background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.1); text-align: center; border-left: 5px solid {{ $color }}; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="font-size: 36px; font-weight: 700; color: {{ $color }}; margin-bottom: 8px;">{{ $value }}</div>
        <div style="font-size: 14px; color: #666; display: flex; align-items: center; justify-content: center; gap: 6px;">
            <i class="{{ $icon }}"></i> {{ $label }}
        </div>
    </div>
@else
    <div class="stat-card" style="background: {{ $gradient }}; color: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.15); transition: transform 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="font-size: 36px; margin-bottom: 15px; opacity: 0.9;">
            <i class="{{ $icon }}"></i>
        </div>
        <h3 style="font-size: 36px; font-weight: 700; margin: 0 0 8px 0;">{{ $value }}</h3>
        <p style="margin: 0 0 15px 0; opacity: 0.9; font-size: 14px;">{{ $label }}</p>
        @if($link && $linkText)
            <a href="{{ $link }}" class="stat-link" style="color: #fff; text-decoration: none; font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 5px; opacity: 0.9;">
                {{ $linkText }} <i class="fa-solid fa-arrow-right"></i>
            </a>
        @endif
    </div>
@endif

