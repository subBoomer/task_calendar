declare module '@popperjs/core/dist/esm/popper' {
    import { Placement, OptionsGeneric } from '@popperjs/core';
  
    export default class Popper {
      constructor(reference: HTMLElement, popper: HTMLElement, options?: OptionsGeneric);
  
      update(): void;
      destroy(): void;
      setOptions(options: OptionsGeneric): void;
    }
  
    export function createPopper(
      reference: HTMLElement | null,
      popper: HTMLElement | null,
      options?: Partial<OptionsGeneric>
    ): Instance;
  
    export interface Instance {
      update(): void;
      destroy(): void;
      setOptions(options: OptionsGeneric): void;
    }
  
    export type Modifier<TData> = ((
      data: TData,
      options: OptionsGeneric
    ) => TData | null) & { name: string };
  
    export interface OptionsGeneric {
      placement?: Placement;
      modifiers?: Array<Partial<Modifier<any>>>;
      strategy?: 'absolute' | 'fixed';
    }
  }