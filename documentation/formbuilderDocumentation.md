# Formbuilder documentation
This is a rather informal documentation (or maybe ramblings of a madman), that covers changes made since issue : [Review design of data entry forms to make mandatory vs. optional fields clearer](https://github.com/younginnovations/iatipublisher/issues/1553).

## Things to note.

### Backend
1. When working with any sort of changes in form on a UI level, make sure to pay attention to `_form.scss`, `formbuilder.ts`, files in `app/IATI/Elements/Forms/` and files in `IATI/Data/`.
2. Files in `IATI/Data/` basically contain the schema of a form. What elements and attributes should a form contain? What forms are frozen? What forms are collapsable? Name, label, hover text, help text all are determined from here. Basically every thing you see inside a form is here, but not how you see the form.
3. The files in `app/IATI/Elements/Forms/` determine which type of form is going to be displayed. The files here determine what the INITIAL form will be. The most important file among these is the `app/IATI/Elements/Forms/BaseForm.php` since all form will use `BaseForm`, it's just a matter of where. (Either top level or nested subelement level). Look at this file to see which element uses which form initially.
4. The creator files (i.e files in `app/IATI/Elements/Builder/`) are used by service files (i.e files in `app/IATI/Services`) to determine which element's edit form is created by which form. There is nothing much to note in creator files except for the css id selector given to the actual forms. Specially in `editForm()` method of `app/IATI/Elements/Builder/ResultElementFormCreator.php` and  `app/IATI/Elements/Builder/TransactionElementFormCreator.php`. I'm giving distinct css selector id for result, indicator, period and transaction form. They will be used by css to bring some precision when rendering their form.
5. Regarding add more buttons. Add more can either be done on attribute or elements. Each file in `app/IATI/Elements/Forms/` will have its own logic to handling add more button for element.
6. So basically the form builder files in the backend will give components (forms, delete buttons, fields, add more button) and their css classes based on the element. 
7. As you see, we get reused components but css classes attached to them are similar (not same). When debugging forms UI issue, it will be hard to determine where the error is from because of css class similarity. To tackle this, I've added simple classes, "one", "two", "three", etc .  This classes will help in 2 areas:
    - Debugging. (Basically figure out which file to check if theres any error)
    - Writing complex css selectors to bring design accuracy and maintain consistency. (Basically writing logic in css)

### Frontend (scss)
1. IMPORTANT: There is conditional logic implemented in `resources/assets/sass/component/_forms.scss`.
2. IMPORTANT: Do not remove the use of simple classes ("one", "two", "three"). Those classes are used to handle edge cases and bring design accuracy and consistency.
3. I've added some documentation to some complex selectors. (Basically which which element will be affected by this css)
4. When  to use scss? 
   - USE WHEN: "I've made change to the classes assigned from backend but  for this specific element / nested subelement the class should work but is not working." OR "Yikes. that small change in class assignment from backend works for this form/element/sublement but broke everything else." 
   - NOT WHEN: "I will use css to implement this small design change everywhere at once."
### Frontend (TS)
1. The `resources/assets/js/scripts/formbuilder.ts` is responsible for basically rendering the form and adding form behaviour. Example: Add another form, Actually Collapsing the form, Delete functionality and more. 

#### Handle collapse behaviour (formbuilder.ts)
| Function Name                          | Purpose                                                                                                                                                   | Dependent functions                                                                                 |
|----------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------|
| `attachCollapsableButtonEvents`        | Attaches a click event listener to the button that controls the collapsible flow, toggling visibility of optional text and expanding/collapsing sections. | `getClosestLabelDom`, `getOptionalTextDom`, `getClosestParentSubelementDom`, `toggleAccordionItems` |
| `getClosestLabelDom`                   | Returns the closest `<label>` element to the specified button.                                                                                            | -                                                                                                   |
| `getOptionalTextDom`                   | Returns the closest element with the class `optional-text` within the specified label.                                                                    | -                                                                                                   |
| `getClosestParentSubelementDom`        | Returns the closest parent element with classes `subelement rounded-t-sm` from the specified label.                                                       | -                                                                                                   |
| `toggleOptionalText`                   | Toggles the rendered display of optional text (either a dot/icon or brackets) based on the current state.                                                 | -                                                                                                   |                                                                                              
| `toggleAccordionItems`                 | Toggles the collapsed state of accordion items, handling visibility of the "Add Additional" button and adjusting the display of hideable subelements.     | `isAddAdditionalButtonOutside`                                                                      |
| `attachInitialCollapsableButtonEvents` | Handles forms rendered on initial page load by attaching collapsible button events to all buttons with the class `collapsable-button`.                    | `attachCollapsableButtonEvents`                                                                     |
| `observeNewCollapsableButtons`         | Observes for new collapsible buttons added to the DOM, attaching events to newly added buttons with the class `collapsable-button`.                       | `attachCollapsableButtonEvents`                                                                     |


### Detailed comments.

- **attachCollapsableButtonEvents**: This function performs two main things:
  1. Adds a click event listener to the button to control the collapsible flow:
     - It finds the closest <label> element related to the button.
     - Within that <label>, it looks for an element with the class 'optional-text'.
         - If it finds 'optional-text', it toggles how that text is displayed (either with brackets or an icon).
     - It also locates the nearest parent element with the classes 'subelement rounded-t-sm'.
         - If that parent subelement exists, it toggles its state to either collapse or expand the form section.
     - Finally, it rotates the collapse button each time it’s clicked.
  2. It triggers the button click event if the subelement is optional using the flag: thisButtonBelongsToOptionalForm.
     This ensures optional forms start off collapsed by default when rendered.

- **toggleAccordionItems** : Toggles collapsed state. (expand or collapsed). Key considerations:
  1. The "Add Additional" button can be either inside or outside the subelement.
  2. When the button is outside, it will always be the immediate sibling to the subelement.
  3. The collapse mechanism is handled by adjusting the max height to give the illusion of sliding up.
  4. If the button is outside the subelement, the slide-up effect will not affect the button. Therefore, we toggle the 'display-none' class to control its visibility.
