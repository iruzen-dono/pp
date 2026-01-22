# 🎨 CSS Design Guide - Key Classes & Features

## Color Variables (Customize Here!)

```css
:root {
    --primary: #6366f1;         /* Indigo - Main color */
    --primary-dark: #4f46e5;    /* Darker indigo */
    --primary-light: #818cf8;   /* Lighter indigo */
    
    --accent: #ec4899;          /* Pink - Accent */
    --accent-dark: #db2777;     /* Darker pink */
    --accent-light: #f472b6;    /* Lighter pink */
    
    --dark: #0f172a;            /* Main background */
    --darker: #020617;          /* Darkest background */
    
    --success: #10b981;         /* Green */
    --warning: #f59e0b;         /* Orange */
    --danger: #ef4444;          /* Red */
}
```

---

## Main Layout Classes

### `.hero`
- Full-width hero section with gradient background
- Animated radial gradients in background
- Centered content with max-width
- Padding: 80px vertical

```css
.hero {
    background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(236,72,153,0.1));
    animation: float effects
}
```

### `.container`
- Max-width: 1400px
- Centered with auto margins
- Padding for mobile safety

### `.admin-wrapper`
- Grid layout: `250px 1fr` (sidebar + content)
- Used on all admin pages

### `.admin-sidebar`
- Fixed width: 250px
- Sticky positioning
- Custom navigation styling

---

## Button Variants

### `.btn.btn-primary`
- Indigo gradient background
- White text
- Box shadow on hover
- translateY(-2px) on hover

```css
.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.4);
}

.btn-primary:hover {
    box-shadow: 0 6px 20px rgba(99, 102, 241, 0.6);
}
```

### `.btn.btn-secondary`
- Pink outline variant
- Semi-transparent background
- Fill on hover

### `.btn.btn-danger`
- Red gradient
- For delete actions

### `.btn.btn-success`
- Green gradient
- For positive actions

---

## Card Components

### `.feature-card`
- Semi-transparent dark background
- Blue border
- Hover: translateY(-10px) + accent border
- Border-radius: 1rem

```css
.feature-card {
    background: rgba(30, 41, 59, 0.5);
    border: 1px solid rgba(99, 102, 241, 0.3);
    transition: all 0.3s ease;
}

.feature-card:hover {
    border-color: var(--accent);
    box-shadow: 0 20px 40px rgba(236, 72, 153, 0.2);
}
```

### `.product-card`
- Flex column layout
- Image container (250px height)
- Content section with padding
- Stock indicator with colors

### `.stat-card`
- 2px colored border
- Semi-transparent background matching border color
- Gradient text values
- 3-column grid layout

#### Variants:
- `.stat-card-primary` - Indigo
- `.stat-card-accent` - Pink
- `.stat-card-success` - Green

---

## Form Elements

### `input, textarea, select`
- Dark background: `rgba(15, 23, 42, 0.5)`
- Blue border
- Rounded corners: 0.5rem
- White text

### Focus State
```css
input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    background: rgba(15, 23, 42, 0.8);
}
```

### `.form-group`
- Margin-bottom: 1.5rem
- Label styling
- Full-width inputs

---

## Table Styling

### `table`
- Width: 100%
- Border-collapse
- Modern styling

### `thead`
- Background: `rgba(99, 102, 241, 0.2)`
- Color: `var(--primary-light)`
- Uppercase text labels

### `tbody tr:hover`
- Background: `rgba(99, 102, 241, 0.1)`
- Smooth transition

### `.table-container`
- Semi-transparent background
- Border with opacity
- Rounded corners
- Overflow handling

---

## Alert Messages

### `.alert`
- Base: Dark background with border-left
- Padding: 1rem
- Margin-bottom: 1rem

#### Variants:
- `.alert-success` - Green border, light green text
- `.alert-danger` - Red border, light red text
- `.alert-warning` - Orange border, yellow text
- `.alert-info` - Blue border, light blue text

---

## Navigation

### `header`
- Sticky positioning
- Blur background: `backdrop-filter: blur(10px)`
- Border-bottom with opacity

### `.nav-links`
- Flex layout
- Underline animation on hover
- Gradient text on hover

```css
.nav-links a::after {
    content: '';
    width: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    transition: width 0.3s ease;
}

.nav-links a:hover::after {
    width: 100%;
}
```

---

## Admin Specific

### `.admin-stats`
- 3-column grid with auto-fit
- Min-width: 250px
- Responsive at smaller screens

### `.admin-sidebar a`
- Padding: 0.75rem 1.5rem
- Smooth transition
- Hover: padding-left increases (animation effect)

### `.admin-sidebar a.active`
- Accent color
- Left border: 3px accent
- Background: semi-transparent accent

### `.admin-form`
- Max-width: 600px
- Centered
- Same styling as cards

---

## Responsive Behaviors

### Tablet (768px)
```css
@media (max-width: 768px) {
    .admin-wrapper { grid-template-columns: 1fr; }
    .hero h1 { font-size: 2.5rem; }
    .products-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
}
```

### Mobile (480px)
```css
@media (max-width: 480px) {
    .hero h1 { font-size: 2rem; }
    .products-grid { grid-template-columns: 1fr; }
    .cart-item { flex-direction: column; }
    form { padding: 1rem; }
}
```

---

## Gradients Used

### Primary Gradient
```css
background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
```

### Primary-Accent Gradient
```css
background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
```

### Radial Gradient (Hero)
```css
background: radial-gradient(circle, rgba(236, 72, 153, 0.1) 0%, transparent 70%);
```

---

## Animations

### Float Animation (Hero)
```css
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(30px); }
}
```

### Transitions (Global)
- Duration: 0.3s
- Timing: ease
- Properties: all, transform, color, border-color, box-shadow

---

## Utility Classes

### Spacing
- `.mt-1, .mt-2, .mt-3` - Margin top
- `.mb-1, .mb-2, .mb-3` - Margin bottom

### Text Alignment
- `.text-center` - Center align
- `.text-right` - Right align

### Visibility
- `.hidden` - Display none (important)

### Special
- `.gradient-text` - Indigo to pink gradient text

---

## How to Customize

### Change Primary Color:
```css
:root {
    --primary: #YOUR_COLOR;
}
```

### Change Accent:
```css
:root {
    --accent: #YOUR_COLOR;
}
```

### Modify Button Size:
```css
.btn {
    padding: YOUR_PADDING;
}
```

### Adjust Border Radius:
```css
.btn, .card {
    border-radius: YOUR_RADIUS;
}
```

---

## Performance Tips

1. **CSS Variables** - Change at root level to affect entire site
2. **Transform & Opacity** - Use for animations (GPU accelerated)
3. **Backdrop Filter** - Works on modern browsers
4. **Graceful Degradation** - Site works without CSS3 features

---

## Browser Compatibility

| Feature | Chrome | Firefox | Safari | Edge |
|---------|--------|---------|--------|------|
| CSS Variables | ✅ | ✅ | ✅ | ✅ |
| Grid | ✅ | ✅ | ✅ | ✅ |
| Backdrop Filter | ✅ | ⚠️ Firefox 103+ | ✅ | ✅ |
| Gradients | ✅ | ✅ | ✅ | ✅ |
| Transform 3D | ✅ | ✅ | ✅ | ✅ |

---

**Happy Customizing! 🎨**
