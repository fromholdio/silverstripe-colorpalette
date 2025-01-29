import Injector from 'lib/Injector';
import ColorPaletteField from "components/ColorPaletteField/ColorPaletteField";

export default () => {
  Injector.component.registerMany({
      ColorPaletteField,
  });
};
