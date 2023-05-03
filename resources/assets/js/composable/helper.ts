/*
 * Helper functions
 */


/*
 * Check if given element is empty or null
 */
export default function isEmpty(element, key = ''){
  if(key === ''){
    return element === '' || element === null;
  }

  return element[key] === '' || element[key] === null;
}
