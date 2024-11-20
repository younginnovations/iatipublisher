import { ToastInterface } from 'Interfaces/ToastInterface';

export interface ErrorInterface extends ToastInterface {
  extra_info: unknown;
}
