const DEVICE_CACHE_KEY = 'air_light_device_info';
const DEFAULT_MOBILE_MAX_WIDTH = 767;

function getViewportWidth() {
  return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth || 0;
}

function getMobileMaxWidth() {
  const widthMaxMobile = parseInt(
    getComputedStyle(document.documentElement).getPropertyValue('--width-max-mobile'),
    10,
  );

  return Number.isFinite(widthMaxMobile) ? widthMaxMobile : DEFAULT_MOBILE_MAX_WIDTH;
}

function readCachedDeviceInfo() {
  try {
    const raw = sessionStorage.getItem(DEVICE_CACHE_KEY);

    if (!raw) {
      return null;
    }

    const parsed = JSON.parse(raw);

    if (
      !parsed
      || typeof parsed.viewportWidth !== 'number'
      || typeof parsed.mobileMaxWidth !== 'number'
      || typeof parsed.isMobile !== 'boolean'
    ) {
      return null;
    }

    return parsed;
  } catch {
    return null;
  }
}

function writeCachedDeviceInfo(info) {
  try {
    sessionStorage.setItem(DEVICE_CACHE_KEY, JSON.stringify(info));
  } catch {
    // Ignore cache write issues (private mode, quota, etc.)
  }
}

function calculateDeviceInfo() {
  const viewportWidth = getViewportWidth();
  const mobileMaxWidth = getMobileMaxWidth();

  return {
    viewportWidth,
    mobileMaxWidth,
    isMobile: viewportWidth <= mobileMaxWidth,
  };
}

function getDeviceInfo(forceRefresh = false) {
  const currentViewportWidth = getViewportWidth();
  const currentMobileMaxWidth = getMobileMaxWidth();

  if (!forceRefresh) {
    const cachedInfo = readCachedDeviceInfo();

    if (
      cachedInfo
      && cachedInfo.viewportWidth === currentViewportWidth
      && cachedInfo.mobileMaxWidth === currentMobileMaxWidth
    ) {
      return cachedInfo;
    }
  }

  const deviceInfo = calculateDeviceInfo();
  writeCachedDeviceInfo(deviceInfo);

  return deviceInfo;
}

function isMobileViewport(forceRefresh = false) {
  return getDeviceInfo(forceRefresh).isMobile;
}

function initDeviceDetectionCache() {
  getDeviceInfo(true);

  let resizeTimeout;
  const updateCache = () => {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(() => {
      getDeviceInfo(true);
    }, 120);
  };

  window.addEventListener('resize', updateCache);
  window.addEventListener('orientationchange', updateCache);
}

export {
  getDeviceInfo,
  isMobileViewport,
  initDeviceDetectionCache,
};
