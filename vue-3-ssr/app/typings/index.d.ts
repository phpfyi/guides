import { RequestHandler, Request, Response } from 'express';
import { App } from 'vue';

export declare namespace SSR {
  /**
   * Denotes a function scoped to, and with access to the SSR context
   */
  type Scoped = (ctx: Context) => any;

  /**
   * The context data used during SSR 
   */
  interface Context {
    config: Config,
    directories: Directories,
    paths: Paths
  }

  /**
   * Base config data for the SSR context
   */
  interface Config {
    port: string | number,
    root: string,
    https: boolean,
    reload: boolean;
    template: string,
    manifest: string,
    entry: EntryPoints,
  }

  /**
   * Entry point config for the dist, server, and client folders for the SSR context
   */
  interface EntryPoints {
    dist: string,
    client: string,
    server: string,
  }

  interface Directories {
    /**
     * Returns the full system path to the [dist]/ folder
     */
    dist: () => string,
    /**
     * Returns the full system path to the [dist]/[client]/ folder
     */
    client: () => string,
    /**
     * Returns the full system path to the [dist]/[server]/ folder
     */
    server: () => string,
  }

  interface Paths {
    /**
     * Returns the full system path to the [dist]/[client]/.../index.html file
     */
    template: () => string,
    /**
     * Returns the full system path to the [dist]/[server]/.../ssr-manifest.json file
     */
    manifest: () => string,
  }

  /**
   * The app instance and app state are returned as the bundle context after
   * the app is invoked
   */
  interface BundleContext {
    app: App,
    state: Record<string, any>
  }

  /**
   * The output context which is passed to the index.html template is the
   * rendered app HTML and the encoded JSON state
   */
  interface OutputContext {
    app: string,
    state: string
    meta: string
  }

  /**
   * Object representation of the server js bundle
   * 
   * The server js bundle is executed by node and its output captured to create 
   * the HTML output with the rendered app and initial state
   */
  interface Bundle {
    /**
     * Returns the [dist]/[server]/.../ssr-manifest.json file
     * 
     * This file contains a mapping of non hashed file names to hashed file names
     * 
     * Using this file you can find the entry point server.[hash].js file
     */
    manifest: () => Record<any, any>
    /**
     * Returns the [dist]/[server]/.../server.[hash].js file
     */
    path: () => string,
    /**
     * Executes the server bundle and returns the app and state context
     */
    entry: (req: Request) => Promise<BundleContext>,
  }

  interface Renderer {
    /**
     * Creates and returns the SSR response data promise
     */
    response: (req: Request, res: Response) => Promise<void>,
    /**
     * Converts the server app and state context data into the template context data
     */
    context: (context: BundleContext) => Promise<OutputContext>,
    /**
     * Renders the app HTML and the state JSON into the template
     */
    hydrate: (template: Buffer, context: OutputContext) => string
  }

  interface Middleware {
    /**
     * Set the server to serve the static public files while ignoring index.html
     */
    assets: () => RequestHandler<Response<any, Record<string, any>>>,
    /**
     * Enable / disable https
     */
    https: () => (req: Request, res: Response, next: () => any) => void,
    /**
     * Creates the live reload server watches for file changes
     * 
     * Connect live reload injects a script into the page HTML to listen for changes and reloads the page
     */
    reload: () => any,
  }

  /**
   * Gracefully handles the exiting of the server application
   */
  type ExitHandler = (options: Record<string, boolean>, code: number) => void
}