# Nexus Demo Files

Each demo folder contains the following import files:

| File | Description |
|------|-------------|
| `content.xml` | WordPress eXtended RSS — all posts, pages, menus, attachments |
| `widgets.wie` | Widget data exported by Widget Importer & Exporter |
| `customizer.dat` | Customizer settings exported by Customizer Export/Import |
| `revolution-slider.zip` | Revolution Slider export (optional, if demo uses it) |
| `preview.jpg` | 1170×600 demo preview image |

## Demo List

| # | Demo | Niche | WooCommerce |
|---|------|-------|:-----------:|
| 01 | Business | Corporate / Agency | No |
| 02 | Creative Agency | Design / Branding | No |
| 03 | Restaurant | Food & Beverage | No |
| 04 | Fashion Shop | eCommerce / Apparel | Yes |
| 05 | Portfolio | Personal / Freelancer | No |
| 06 | SaaS | Software / Tech | No |
| 07 | Medical | Healthcare / Clinic | No |
| 08 | Finance | Banking / Consulting | No |
| 09 | Education | Online Courses / Academy | No |
| 10 | Real Estate | Property Listings | No |
| 11 | Gym & Fitness | Sports / Wellness | No |
| 12 | Travel | Tourism / Agency | Yes |
| 13 | Photography | Studio / Portfolio | No |
| 14 | Law Firm | Legal Services | No |
| 15 | Startup | Product Launch | No |

## Import Instructions

1. Install and activate Nexus theme
2. Run the Nexus Setup Wizard (Appearance → Nexus Setup)
3. Select the demo you want and click **Import**
4. Wizard will import: content → widgets → customizer → set front page → set menus

## Manual Import

If using Merlin WP outside the wizard context:

```bash
wp import demos/01-business/content.xml --authors=create
wp widget import demos/01-business/widgets.wie
```
