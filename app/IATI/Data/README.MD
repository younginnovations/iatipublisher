# NOTES ON ELEMENT JSON SCHEMA PROPERTIES:

1. `{ ... criteria: mandatory ... }` will give red asterisk.
2. `{ ... required: true ... }` wont necessarily mean required validation.
3. `{ ... element_criteria : mandatory ... }` will give `element` core element icon.
4. `{ ... read_only: true ...}` will freeze the element. See `reporting_org` for reference.
5. `{ ... is_collapsable: true ... }` will make the element collapsable. See `document_link` for reference. Will need tweaks on `formbuilder.ts` on issues.
6. `{ ... show_full_help_text: true ... }` will render the actual `help_text` instead of 'Help' text for form fields. See `activity.document_link.url` for reference.
