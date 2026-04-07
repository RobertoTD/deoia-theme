(function () {
  "use strict";

  const trigger = document.querySelector("[data-deoia-video-trigger]");
  const modal = document.getElementById("deoia-video-modal");

  if (!trigger || !modal) {
    return;
  }

  const frame = modal.querySelector("[data-deoia-video-frame]");
  const closeButton = modal.querySelector("[data-deoia-video-close]");
  const embedUrl = (trigger.dataset.videoEmbed || "").trim();

  if (!frame || !closeButton || !embedUrl) {
    return;
  }

  let lastFocusedElement = null;

  function openModal() {
    lastFocusedElement = document.activeElement;
    frame.src = embedUrl;
    modal.classList.remove("hidden");
    modal.classList.add("flex");
    modal.setAttribute("aria-hidden", "false");
    document.body.classList.add("overflow-hidden");
    closeButton.focus();
  }

  function closeModal() {
    modal.classList.add("hidden");
    modal.classList.remove("flex");
    modal.setAttribute("aria-hidden", "true");
    frame.src = "";
    document.body.classList.remove("overflow-hidden");

    if (lastFocusedElement instanceof HTMLElement) {
      lastFocusedElement.focus();
    }
  }

  trigger.addEventListener("click", function (event) {
    event.preventDefault();
    openModal();
  });

  closeButton.addEventListener("click", closeModal);

  modal.addEventListener("click", function (event) {
    if (event.target === modal) {
      closeModal();
    }
  });

  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape" && modal.getAttribute("aria-hidden") === "false") {
      closeModal();
    }
  });
})();
