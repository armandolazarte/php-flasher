import { AbstractPlugin } from '@flasher/flasher/dist/plugin';
import type { Envelope, Options } from '@flasher/flasher/dist/types';
export default class NotyPlugin extends AbstractPlugin {
    renderEnvelopes(envelopes: Envelope[]): void;
    renderOptions(options: Options): void;
}
