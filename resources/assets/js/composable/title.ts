/**
 * Get current activity title
 */

function getActivityTitle(
  data: { language: string; narrative: string }[],
  language: string
) {
  let title = '';

  // for (const t of data) {
  //   // if (t.language === language) {
  //   //   title = t.narrative;
  //   // }


  // }
  title = data['0'].narrative;
  return title??'Untitled';
}

export default getActivityTitle;
