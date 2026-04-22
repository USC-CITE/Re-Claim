document.addEventListener("DOMContentLoaded", function () {
  const descriptions = document.querySelectorAll(".description-text");

  const MAX_LENGTH = 100;

  descriptions.forEach((desc) => {
    const fullText = desc.textContent.trim();
    if (fullText.length <= MAX_LENGTH) return;

    const truncated = fullText.substring(0, MAX_LENGTH);

    // Set initial truncated state with inline button
    const setTruncated = () => {
      desc.innerHTML = "";
      const textSpan = document.createElement("span");
      textSpan.textContent = truncated + "...";
      desc.appendChild(textSpan);

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'read-more-inline text-sm font-semibold text-[#055BA8] hover:underline ml-1 cursor-pointer inline-block';
      btn.textContent = 'Read more';
      btn.onclick = (e) => {
        e.preventDefault();
        setExpanded();
      };
      desc.appendChild(btn);
    };

    const setExpanded = () => {
      desc.innerHTML = '';
      const textSpan = document.createElement('span');
      textSpan.textContent = fullText;
      desc.appendChild(textSpan);

      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'read-more-inline text-sm font-semibold text-[#055BA8] hover:underline ml-1 cursor-pointer inline-block';
      btn.textContent = 'Show less';
      btn.onclick = (e) => {
        e.preventDefault();
        setTruncated();
      };
      desc.appendChild(btn);
    };

    setTruncated();
  });

  document.querySelectorAll(".read-more-btn").forEach((btn) => btn.remove());
});
