// Import Font Awesome core
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// Import solid icons
import { 
  faPhone,
  faLocationDot,
  faClock,
  faEnvelope,
  faBars,
  faTimes,
  faChevronDown
} from '@fortawesome/free-solid-svg-icons';

// Import brand icons
import { 
  faInstagram,
  faFacebook
} from '@fortawesome/free-brands-svg-icons';

// Add icons to library
library.add(
  // Solid icons
  faPhone,
  faLocationDot,
  faClock,
  faEnvelope,
  faBars,
  faTimes,
  faChevronDown,
  // Brand icons
  faInstagram,
  faFacebook
);

// Watch the DOM for icon replacements
dom.watch();
