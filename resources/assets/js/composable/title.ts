/**
 * Get current activity title
 */

function getActivityTitle(
  data: { language: string; narrative: string }[],
  language: string
) {
  let title = '';

  for (const t of data) {
    if (t.language === language) {
      title = t.narrative;
    }
  }
  return title;
}

export default getActivityTitle;
