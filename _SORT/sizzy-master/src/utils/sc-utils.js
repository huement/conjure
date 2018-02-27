import {css} from 'styled-components';
import ORIENTATIONS from 'config/orientations';

export const cond = (condition, rule) => (condition ? rule : '');

export const withoutLast = (rule, lastRule) =>
  `
  ${rule}
  
  &:last-child {
    ${lastRule}
  }
`;

export const withoutLastOfType = (rule, lastRule) =>
  `
  ${rule}
  
  &:last-of-type{
    ${lastRule}
  }
`;

export const oneOf = (prop, obj) => `${obj[prop]};`;

export const placeholder = style =>
  `
  &::-webkit-input-placeholder {
   ${style}
  }

  &:-moz-placeholder {
    ${style}
  }

  &::-moz-placeholder {
    ${style}
  }

  &:-ms-input-placeholder {  
    ${style}
  }
`;

export const noSelect = `
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
`;

export const proportional = (p = 1) =>
  `
  &:after {
    content: "";
    display: block;
    padding-bottom: ${p * 100}%;
  }
`;

export const absoulteFull = `
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  bottom: 0;
`;

export const whenHovering = (className, rule) =>
  `
  &:hover {
    .${className} {
      ${rule}
    }
  }
`;

export const showOnHover = className => whenHovering(className, 'opacity: 1;');
export const displayOnHover = (className, display = 'flex') =>
  whenHovering(className, `display: ${display} !important;`);

export const coverImage = url =>
  `
  background: url("${url}") no-repeat center;
  background-size: cover;
  background-position: center;
`;

export const removeTouchHighlight = `-webkit-tap-highlight-color: rgba(0,0,0,0);`;

export const ellipsis = `
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
`;

export const size = s =>
  `
  width: ${s};
  height: ${s};
`;

export const maxSize = s =>
  `
  max-width: ${s};
  max-height: ${s};
`;

export const minSize = s =>
  `
  max-width: ${s};
  max-height: ${s};
`;

export const minHeight = s =>
  `
  height: ${s}px;
  min-height: ${s};
  min-height: ${s};
`;

export const mustSize = s =>
  `
 ${size(s)}
 ${minSize(s)}
 ${maxSize(s)}
`;

export const line = (color = 'gray', size = 1) =>
  `
  height: ${size}px;
  border: none;
  background-color: ${color};
`;

export const iconSize = size =>
  `
  font-size: ${size}px !important;
  height: ${size}px;
  width: ${size}px;
`;

export const rotateIconOnOrientationChange = css`
  ${p => cond(p.orientation === ORIENTATIONS.LANDSCAPE, `
    transform: rotate(-90deg);
  `)}
`;

export const smoothScroll = `-webkit-overflow-scrolling: touch;`;
